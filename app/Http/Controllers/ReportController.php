<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MixOrder;
use App\AnalisisAgua;
use App\Granel;
use App\Estandares;
use App\Controles;
use App\Packing;
use App\Inspecciones;
use App\ControlProducto;
use Illuminate\Support\Facades\DB;   
use PDF;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{

    public function mixorder($id)
    {
        /** Validación de permisos */
        $order = MixOrder::find($id);

        if (!$order) {
            return "Orden no encontrada";
        }

        $order->load('mixMaterials');

        // Aplica formato a observaciones
        $order->observaciones = $this->formatObservations($order->observaciones);

        $data = ['data' => $order];

        $fechaActual = date('Y-m-d');
        $pdf = PDF::loadView('reports.mixorder', $data);

        return $pdf->download("OrdenMezcla{$fechaActual}.pdf");
    }


    private function formatObservations($text) 
    {
        if (!$text) return '';

        $text = trim($text);
        if ($text === '') return '';

        $result = '';

        // 🟢 Hay separador => [texto manual] | Bitácora [bitácora automática]
        if (str_contains($text, '| Bitácora')) {
            [$textoManual, $bitacoraAutomatica] = explode('| Bitácora', $text, 2);

            $textoManual        = trim($textoManual);
            $bitacoraAutomatica = trim($bitacoraAutomatica);

            // 1) Texto manual entre paréntesis
            if ($textoManual !== '') {
                $result .= '(' . htmlspecialchars($textoManual) . ')';
            }

            // 2) Bitácora con etiqueta y salto de línea
            if ($bitacoraAutomatica !== '') {
                if ($result !== '') {
                    $result .= '<br>'; // salto de línea entre manual y bitácora
                }

                $result .= '<strong>Bitácora: </strong>' 
                        . $this->formatBitacora($bitacoraAutomatica);
            }

            return $result;
        }

        // 🔍 No hay "| Bitácora": probamos si el texto completo es formato de bitácora
        $bitacoraFormateada = $this->formatBitacora($text);

        if ($bitacoraFormateada !== '') {
            return '<strong>Bitácora: </strong>' . $bitacoraFormateada;
        }

        // Si no tiene formato de bitácora, lo tratamos como texto manual
        return '(' . htmlspecialchars($text) . ')';
    }
    private function formatBitacora($text)
    {
        $result = '';
        $lines = preg_split('/\r\n|\r|\n/', $text);

        foreach ($lines as $line) {
            if (preg_match('/^(\d+):\s*(.+)$/', $line, $matches)) {
                $code = $matches[1];
                $changes = explode(',', $matches[2]);

                $formattedChanges = array_map(function ($cambio) {
                    return '<span class="defblue1">' . trim($cambio) . '</span>';
                }, $changes);

                // Sin salto de línea, solo espacio entre bloques
                $result .= '<span style="font-weight: bold; color: black;">' . $code . ':</span> '
                        . implode(', ', $formattedChanges) . ' ';
            }
        }

        return $result;
    }

    public function packing($id)
    {
        /** Buscar la orden de empaque */
        $order = Packing::find($id);
        if (!$order) {
            return "Orden no encontrada";
        }

        /** Buscar la hoja de inspección asociada por num_id */
        $inspeccion = \App\Inspecciones::whereRaw("REPLACE(num_id, ' ', '') = ?", [preg_replace('/\s+/', '', $order->num_id)])->first();

        // Si no existe, crear objeto vacío para evitar errores
        if (!$inspeccion) {
            $inspeccion = (object)[
                'ptotal' => 0,
                'rendimientomezcla' => 0,
                'totalkilogramosvacios' => 0,
                'productoterminado1' => '',
                'productoterminado2' => '',
                'capacidad' => 0,
                'consumobobina' => 0,
            ];
        }

        /** Pasar ambos objetos a la vista */
        $data = [
            'data' => $order,
            'inspeccion' => $inspeccion
        ];

        $pdf = \PDF::loadView('reports.packing', $data);
        $fechaActual = date('Y-m-d');

        return $pdf->download("OrdenEmpaque_{$order->num_id}_{$fechaActual}.pdf");
    }


    // public function packing($id){
    //     /**Validar permisos */
    //     $order = Packing::find($id);
    //     if(!$order){
    //         return "Orden no encontrada";
    //     }

    //     $data = ['data' => $order];
    //     $pdf = PDF::loadView('reports.packing', $data);
    //     $fechaActual= date('Y-m-d');
    //     return $pdf->download("OrdenEmpaque".$fechaActual.".pdf");
    // }

    public function vinietas($id){
        $order = MixOrder::find($id);
        //Crear vista para manejar este tipos de excepciones
        if(!$order){
            return "Orden no encontrada";
        }

        $order->load('mixMaterials');
        $data = ['data' => $order];
        // echo json_encode($data);
        $pdf = PDF::loadView('reports.vinietas', $data);

        $fechaActual= date('Y-m-d');
        return $pdf->download("Vinietas".$fechaActual.".pdf");
    }

    public function analisisagua(Request $request,$order_code){
        $tmp = new AnalisisAgua();
        $usuario= $this->obtenerUsuario($request);
        $analisis= $tmp->search($order_code, $usuario);
        $analisis= json_decode(json_encode($analisis),FALSE);
        if($analisis->code == 1 && $analisis->data->analisis->status==3 || $analisis->data->analisis->status==4){
            $especificacion= $tmp->getEspecificacionObject($analisis->data->analisis->especificacion);
            //var_dump($especificacion);
            //exit();
            $data = ['data' => $analisis->data, 'especificacion' => $especificacion];
            $pdf = PDF::loadView('reports.analisisagua', $data);
            $fechaActual= date('Y-m-d');
            return $pdf->download('AnalisisAgua'.$fechaActual.'.pdf');
        }
        else{
            return "Orden no encontrada";
        }
    }

    public function controlProducto(Request $request, $order_code)
    {
        $control = \App\ControlProducto::where('numero_orden', $order_code)->first();
        
        if (!$control) {
            return "Orden no encontrada";
        }
        
        // Estructura de datos adaptada al template existente
        $data = (object) [
            'analisis' => (object) [
                // Control del agua
                'ph_agua'          => $control->ph_agua,
                'conductividad_agua' => $control->conductividad_agua,
                'cloro_libre_agua' => $control->cloro_libre_agua,
                
                // Control del producto
                'ph_producto'      => $control->ph_producto,
                'especificacion_ph_producto' => $control->especificacion_ph_producto,
                'viscosidad_producto' => $control->viscosidad_producto,
                'especificacion_viscosidad_producto' => $control->especificacion_viscosidad_producto,
                'densidad_producto' => $control->densidad_producto,
                'especificacion_densidad_producto' => $control->especificacion_densidad_producto,
                
                // Asegurarse que estos valores sean interpretados correctamente como booleanos
                'apariencia_producto' => (int)$control->apariencia_producto,
                'color_producto' => (int)$control->color_producto,
                'olor_producto' => (int)$control->olor_producto,
                
                'observaciones_producto' => $control->observaciones_producto,
                
                // Autorizaciones
                'usuario_crea'     => $control->usuario_crea,
                'usuario_verifica' => $control->usuario_verifica,
                'usuario_autoriza' => $control->usuario_autoriza,
                'rol_crea'         => $control->rol_crea,
                'rol_verifica'     => $control->rol_verifica,
                'rol_autoriza'     => $control->rol_autoriza,
            ],
            'orden' => (object) [
                'order_date'   => $control->created_at->format('Y-m-d'),
                'product_code' => $control->codigo_producto ?? '-',
                'num_id'       => $control->numero_orden,
                'product_name' => $control->nombre_producto ?? '-',
            ]
        ];
        
        $pdf = \PDF::loadView('reports.controlproducto', [
            'data' => $data
        ])->setPaper('a4', 'portrait');
        
        $fechaActual = date('Y-m-d');
        return $pdf->download('ControlProducto_'.$fechaActual.'.pdf');
    }


  public function granel(Request $request, $order_code)
    {
        $tmp = new Granel();
        $usuario = $this->obtenerUsuarioGranel($request);
        $granel = $tmp->search($order_code, $usuario);
        $granel = json_decode(json_encode($granel), FALSE);

        if ($granel->code == 1) {

            // Mapear parametros por ID
            $parametros = collect($granel->data->granel->parametros)->keyBy('id');

            $data = ['data' => $granel->data];

            // Llenar los parámetros
            // VISCOSIDAD
            $data['data']->granel->viscosidad = $parametros['VISCOSIDAD']->values->especification;
            $data['data']->granel->viscosidad_resultado = $parametros['VISCOSIDAD']->values->results;
            $data['data']->granel->viscosidad_temp = $parametros['VISCOSIDAD']->values->temp;
            $data['data']->granel->viscosidad_firma = $parametros['VISCOSIDAD']->values->create_by;

            // PH
            $data['data']->granel->ph = $parametros['PH']->values->especification;
            $data['data']->granel->ph_resultado = $parametros['PH']->values->results;
            $data['data']->granel->ph_temp = $parametros['PH']->values->temp;
            $data['data']->granel->ph_firma = $parametros['PH']->values->create_by;

            // DENSIDAD
            $data['data']->granel->densidad = $parametros['DENSIDAD']->values->especification;
            $data['data']->granel->densidad_resultado = $parametros['DENSIDAD']->values->results;
            $data['data']->granel->densidad_temp = $parametros['DENSIDAD']->values->temp;
            $data['data']->granel->densidad_firma = $parametros['DENSIDAD']->values->create_by;

            // $data['data']->granel->viscosidad = $parametros['VISCOSIDAD']->values->especification;
            // $data['data']->granel->viscosidad_resultado = $parametros['VISCOSIDAD']->values->results;
            // $data['data']->granel->viscosidad_temp = $parametros['VISCOSIDAD']->values->temp;

            // $data['data']->granel->ph = $parametros['PH']->values->especification;
            // $data['data']->granel->ph_resultado = $parametros['PH']->values->results;
            // $data['data']->granel->ph_temp = $parametros['PH']->values->temp;

            // $data['data']->granel->densidad = $parametros['DENSIDAD']->values->especification;
            // $data['data']->granel->densidad_resultado = $parametros['DENSIDAD']->values->results;
            // $data['data']->granel->densidad_temp = $parametros['DENSIDAD']->values->temp;

            // Validación del checkbox para COLOR IGUAL A PATRON
            $cv1 = isset($data['data']->granel->cv1) ? $data['data']->granel->cv1 : 0;
            $cv2 = isset($data['data']->granel->cv2) ? $data['data']->granel->cv2 : 0;
            $data['data']->granel->checkbox_result = ($cv1 == 1 && $cv2 == 1) ? 'CUMPLE' : 'NO CUMPLE';

            $pdf = PDF::loadView('reports.granel', $data);
            $fechaActual = date('Y-m-d');
            return $pdf->download('EtiquetaGranel' . $fechaActual . '.pdf');
        } else {
            return "Orden no encontrada";
        }
    }



    public function estandaresCalidad(Request $request,$order_code, $turno){
        $tmp = new Estandares();
        $usuario= $this->obtenerUsuarioEstandar($request);
        $estandares= $tmp->search($order_code, $turno, $usuario);
        $estandares= json_decode(json_encode($estandares),FALSE);
        if($estandares->code == 1 && $estandares->data->estandares->seccion==9){
            $data = ['data' => $estandares->data];
            $pdf = PDF::loadView('reports.estandares', $data)->setPaper('a4', 'landscape');
            $fechaActual= date('Y-m-d');
            return $pdf->download('EstandaresCalidad'.$fechaActual.'.pdf');
        }
        else{
            return "Orden no encontrada";
        }
    }


    public function controlesCalidad(Request $request, $order_code, $turno)
    {
        $packing = \App\Packing::whereRaw("REPLACE(num_id, ' ', '') = ?", [preg_replace('/\s+/', '', $order_code)])->first();
        
        if (!$packing) {
            return "Orden no encontrada";
        }

        // Fetch all control sheets for this order
        $allControles = \App\Controles::where('packing_id', $packing->id)->orderBy('created_at', 'asc')->get();

        if ($allControles->isEmpty()) {
            return "No hay controles registrados para esta orden";
        }

        $controlInstance = new \App\Controles();
        $sheets = [];

        foreach ($allControles as $controlModel) {
            $parsedControl = $controlInstance->getParseObject($controlModel);
            $c = $parsedControl;

            // Asegurar 25 posiciones en horas y m7, completando con null si falta
            $horas = array_pad((array) $c->horas, 25, null);
            $pesos = array_pad((array) $c->m7, 25, null);

            // Convertir datos a números o null
            $datos = array_map(function ($v) {
                $val = floatval($v);
                return is_numeric($v) ? $val : null;
            }, $pesos);

            // Líneas horizontales fijas de 25 elementos
            $pmax = array_pad(array_fill(0, count($horas), floatval($c->pmaximo ?? 0)), 25, floatval($c->pmaximo ?? 0));
            $popt = array_pad(array_fill(0, count($horas), floatval($c->poptimo ?? 0)), 25, floatval($c->poptimo ?? 0));
            $pmin = array_pad(array_fill(0, count($horas), floatval($c->pminimo ?? 0)), 25, floatval($c->pminimo ?? 0));

            $chartConfig = [
                'type' => 'line',
                'data' => [
                    'labels' => array_map(function($h) {
                        return ($h === null || trim($h) === '') ? 'N/A' : $h;
                    }, $horas),
                    'datasets' => [
                        [
                            'label' => 'Peso Real',
                            'data' => $datos,
                            'borderColor' => '#007bff',
                            'backgroundColor' => 'rgba(0,123,255,0.3)',
                            'fill' => false,
                            'pointRadius' => 4,
                            'borderWidth' => 2,
                            'tension' => 0
                        ],
                        [
                            'label' => 'Maximo',
                            'data' => $pmax,
                            'borderColor' => 'red',
                            'fill' => false,
                            'pointRadius' => 0
                        ],
                        [
                            'label' => 'Optimo',
                            'data' => $popt,
                            'borderColor' => 'green',
                            'fill' => false,
                            'pointRadius' => 0
                        ],
                        [
                            'label' => 'Minimo',
                            'data' => $pmin,
                            'borderColor' => 'orange',
                            'fill' => false,
                            'pointRadius' => 0
                        ]
                    ]
                ],
                'options' => [
                    'responsive' => true,
                    'plugins' => [
                        'legend' => [
                            'display' => false,
                            'labels' => [
                                'display' => false
                            ]
                        ],
                        'title' => ['display' => false]
                    ],
                    'scales' => [
                        'y' => [
                            'title' => ['display' => false]
                        ],
                        'x' => [
                            'title' => ['display' => false],
                            'ticks' => [
                                'autoSkip' => false,
                                'maxRotation' => 0,
                                'minRotation' => 0,
                                'display' => true
                            ],
                            'grid' => ['display' => false]
                        ]
                    ],
                    'layout' => [
                        'padding' => ['left' => 5, 'right' => 0]
                    ],
                    'interaction' => [
                        'mode' => 'index',
                        'intersect' => false
                    ],
                    'elements' => [
                        'point' => [
                            'hoverRadius' => 0
                        ]
                    ]
                ]
            ];

            try {
                $response = \Illuminate\Support\Facades\Http::get('https://quickchart.io/chart', [
                    'c' => json_encode($chartConfig),
                    'width' => 800,
                    'height' => 500,
                    'format' => 'png',
                    'backgroundColor' => 'white'
                ]);

                $chartImageBase64 = 'data:image/png;base64,' . base64_encode($response->body());
            } catch (\Exception $e) {
                \Log::error('QuickChart Error: ' . $e->getMessage());
                $chartImageBase64 = '';
            }

            $sheets[] = [
                'data' => (object)[
                    'order' => $packing,
                    'controles' => $c
                ],
                'chart_image' => $chartImageBase64
            ];
        }

        $pdf = \PDF::loadView('reports.controles', ['sheets' => $sheets])->setPaper('a4', 'landscape');
        return $pdf->download('ControlesCalidad_' . date('Y-m-d') . '.pdf');
    }



    // public function controlesCalidad(Request $request,$order_code, $turno){
    //     $tmp = new Controles();
    //     $usuario= $this->obtenerUsuarioEstandar($request);
    //     $controles= $tmp->search($order_code,  $turno, $usuario);
    //     $controles= json_decode(json_encode($controles),FALSE);
    //     if($controles->code == 1 && $controles->data->controles->seccion==25){
    //         $data = ['data' => $controles->data];
    //         $pdf = PDF::loadView('reports.controles', $data)->setPaper('a4', 'landscape');
    //         $fechaActual= date('Y-m-d');
    //         return $pdf->download('ControlesCalidad'.$fechaActual.'.pdf');
    //     }
    //     else{
    //         return "Orden no encontrada";
    //     }
    // }

    // public function inspeccionesCalidad(Request $request, $order_code){
    //     $tmp = new Inspecciones();
    //     $usuario= $this->obtenerUsuarioEstandar($request);
    //     $inspecciones= $tmp->search($order_code, $usuario);
    //     $inspecciones= json_decode(json_encode($inspecciones),FALSE);
    //     if($inspecciones->code == 1 && $inspecciones->data->inspecciones->estado==5){
    //         $data = ['data' => $inspecciones->data];
    //         $pdf = PDF::loadView('reports.inspecciones', $data)->setPaper('a4', 'letter');
    //         $fechaActual= date('Y-m-d');
    //         return $pdf->download('InspeccionesCalidad'.$fechaActual.'.pdf');
    //     }
    //     else{
    //         return "Orden no encontrada";
    //     }
    // }

    public function inspeccionesCalidad(Request $request, $order_code)
    {
        $usuario = $this->obtenerUsuarioEstandar($request);

        // Buscar inspecciones
        $tmp = new Inspecciones();
        $inspecciones = $tmp->search($order_code, $usuario);
        $inspecciones = json_decode(json_encode($inspecciones), FALSE);

        $packing = DB::table('packings')
            ->select('id', 'product_name')
            ->whereRaw("REPLACE(num_id, ' ', '') = ?", [preg_replace('/\s+/', '', $order_code)])
            ->first();

        $tanque = DB::table('validaciones_tanque')
            ->whereRaw("REPLACE(numero_orden, ' ', '') = ?", [preg_replace('/\s+/', '', $order_code)])
            ->first();

        // Obtener desglose de TODAS las bobinas
        $bobina = null;
        if ($packing) {
            // Buscar por tipo_prod (puede ser 'Bobina', 'bobina', etc.)
            $bobinaRows = DB::table('empaque_materials')
                ->where('packing_id', $packing->id)
                ->whereRaw("LOWER(TRIM(COALESCE(tipo_prod,''))) LIKE '%bobina%'")
                ->get();

            // Fallback: si tipo_prod está vacío en BD, buscar por descripción (patrón "LAM")
            if ($bobinaRows->isEmpty()) {
                $bobinaRows = DB::table('empaque_materials')
                    ->where('packing_id', $packing->id)
                    ->whereRaw("LOWER(description) LIKE '%lam %'")
                    ->get();
            }

            if ($bobinaRows->isNotEmpty()) {
                $e1 = 0;
                $e2 = 0;
                $dev = 0;
                $descTmp = [];

                foreach($bobinaRows as $bobinaRow) {
                    $e1  += floatval($bobinaRow->entrega1 ?? 0);
                    $e2  += floatval($bobinaRow->entrega2 ?? 0);
                    $dev += floatval($bobinaRow->return   ?? 0);
                    if(!empty($bobinaRow->description)) {
                        $descTmp[] = $bobinaRow->description;
                    }
                }

                $bobina = [
                    'descripcion' => implode(', ', array_unique($descTmp)),
                    'entrega1'    => $e1,
                    'entrega2'    => $e2,
                    'devolucion'  => $dev,
                    'consumo'     => ($e1 + $e2) - $dev,
                ];
            }
        }

        if ($inspecciones->code == 1 && $inspecciones->data->inspecciones->estado == 5) {
            $data = [
                'data'    => $inspecciones->data,
                'packing' => $packing,
                'tanque'  => $tanque,
                'bobina'  => $bobina,
            ];
            $pdf = PDF::loadView('reports.inspecciones', $data)->setPaper('a4', 'letter');
            $fechaActual = date('Y-m-d');
            return $pdf->download('InspeccionesCalidad' . $fechaActual . '.pdf');
        } else {
            return "Orden no encontrada";
        }
    }



    public function obtenerUsuario(Request $request){
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("SupCalidad")) {
            $salida = [
                "email" => "",
                "nombre" => "",
                "rolname" => "",
                "rolabv" => "",
                "cargo" => "",
            ];
        }
        else if($request->user()->hasRole("Calidad")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "CALIDAD",
                "rolabv" => "CL",
                "cargo" => "ANALISTA DE CALIDAD",
            ];
        }
        else if($request->user()->hasRole("Mezcla")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "CleanInPlace",
                "rolabv" => "CIP",
                "cargo" => "CLEAN IN PLACE",
            ];
        }
        else if($request->user()->hasRole("SupCalidad")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "SupCalidad",
                "rolabv" => "SCL",
                "cargo" => "SUPERVISOR DE CALIDAD",
            ];
        }
        $respuesta= json_decode(json_encode($salida),FALSE);
        return $respuesta;
    }

    public function obtenerUsuarioGranel(Request $request){
        if (!$request->user()->hasRole("Mezcla")) {
            $salida = [
                "email" => "",
                "nombre" => "",
                "rolname" => "",
                "rolabv" => "",
                "cargo" => "",
            ];
        }
        else if($request->user()->hasRole("Mezcla")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "Mezcla",
                "rolabv" => "MEZCLA",
                "cargo" => "Encargado de Mezcla",
            ];
        }
        $respuesta= json_decode(json_encode($salida),FALSE);
        return $respuesta;
    }

    public function obtenerUsuarioEstandar(Request $request){
        if (!$request->user()->hasRole("Calidad") && !$request->user()->hasRole("Produccion") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("AuxControlCalidad") && !$request->user()->hasRole("JefeProduccion")) {
            $salida = [
                "email" => "",
                "nombre" => "",
                "rolname" => "",
                "rolabv" => "",
                "cargo" => "",
            ];
        }
        else if($request->user()->hasRole("Calidad")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "CALIDAD",
                "rolabv" => "CL",
                "cargo" => "ANALISTA DE CALIDAD",
            ];
        }
        else if($request->user()->hasRole("Produccion")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "Produccion",
                "rolabv" => "PROD",
                "cargo" => "Analista de Produccion",
            ];
        }
        else if($request->user()->hasRole("SupProduccion")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "SupProduccion",
                "rolabv" => "SPROD",
                "cargo" => "SUPERVISOR DE PRODUCCION",
            ];
        }
        else if($request->user()->hasRole("AuxControlCalidad")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "AuxControlCalidad",
                "rolabv" => "ACL",
                "cargo" => "AUXILIAR CONTROL CALIDAD",
            ];
        }
        else if ($request->user()->hasRole("JefeProduccion")) {
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "JefeProduccion",
                "rolabv" => "JPROD",
                "cargo" => "JEFE DE PRODUCCION",
            ];
        }
        $respuesta= json_decode(json_encode($salida),FALSE);
        return $respuesta;
    }
}
