<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\MixOrder;
use App\Material;
use App\AnalisisAgua AS Water;
use App\ControlProducto;
use App\ResultadoAnalisisAgua;
use App\LotChangesLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Extension para ver reportar logs en caso de error o informacion
use Carbon\Carbon; // Extension para manejo de fechas

class MixController extends Controller
{

    public function statusProgress(Request $request, $order_code)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $order = MixOrder::where('num_id', $order_code)->first();
        if (!$order) {
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        $data["master"] = ["msgs" => "", "complete" => false];
        $data["granel"] = ["msgs" => "", "complete" => false];
        $data["water"] = ["msgs" => "", "complete" => false];
        $data["control_producto"] = ["msgs" => "", "complete" => false];

        switch ($order->status) {
            case 2: $data["master"]["msgs"] = "Pendiente de aprobación\n"; break;
            case 3: $data["master"]["msgs"] = "Pendiente de revisión\n"; break;
            case -1: $data["master"]["msgs"] = "Pendiente de autorización\n"; break;
            case 4: $data["master"]["msgs"] = "Sin iniciar mezcla\n"; break;
            case 5: $data["master"]["msgs"] = "En proceso\n"; break;
            case 6: $data["master"]["msgs"] = "Finalizada (Pendiente de autorización)\n"; break;
            case 7: 
                $data["master"]["msgs"] = "Finalizada y autorizada\n";
                $data["master"]["complete"] = true;
                break;
            default: 
                $data["master"]["msgs"] = "Inconsistencia de estado\n"; 
                break;
        }

        // 🔄 NUEVO: análisis de agua
        $analisis = ResultadoAnalisisAgua::where('estado', 1)->latest('fecha_registro')->first();
        if ($analisis) {
            $data["water"]["msgs"] .= "Análisis de agua creado el " . $analisis->fecha_registro->format('Y-m-d H:i') . "\n";
            $data["water"]["complete"] = true;
        } else {
            $data["water"]["msgs"] .= "No hay análisis de agua creado\n";
        }

        // ✅ Estado de hoja granel
        if ($order->granel == null) {
            $data["granel"]["msgs"] .= "Hoja Granel sin llenar \n";
        } else {
            $data["granel"]["msgs"] .= "Hoja Granel completada \n";
            $data["granel"]["complete"] = true;
        }

        // 🆕 Estado de control de producto
        $control = ControlProducto::where('numero_orden', $order->num_id)->first();

        if ($control) {
            switch ($control->estado) {
                case 1:
                    $data["control_producto"]["msgs"] .= "Control de producto pendiente de verificación\n";
                    break;
                case 2:
                    $data["control_producto"]["msgs"] .= "Control de producto pendiente de autorización\n";
                    break;
                case 3:
                    $data["control_producto"]["msgs"] .= "Control de producto autorizado\n";
                    $data["control_producto"]["complete"] = true;
                    break;
                default:
                    $data["control_producto"]["msgs"] .= "Estado de control de producto desconocido\n";
                    break;
            }
        } else {
            $data["control_producto"]["msgs"] .= "No se encontró control de producto\n";
        }


        $salida["code"] = 1;
        $salida["data"] = $data;
        $salida["msg"] = "Request completed";
        return $salida;
    }


    public function updateUserEntregaMp(Request $request, $id)
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        // Validar permisos
        if(!Auth::user()->hasRole("MateriaPrima")){
            $salida["msg"] = "Operación denegada";
            return response()->json($salida, 403);
        }

        try {
            $order = MixOrder::findOrFail($id);
            
            // Actualizar el campo con el nombre del usuario actual
            $order->user_entrega_mp = session('user_cur_fullname');
            $order->save();

            $order->refresh();
            $order->load('materials');

            $salida["code"] = 1;
            $salida["msg"]  = "Usuario de entrega MP actualizado correctamente";
            $salida["data"] = $order;

            return response()->json($salida);

        } catch (\Exception $ex) {
            \Log::error("Error actualizando user_entrega_mp: " . $ex->getMessage());
            $salida["msg"] = "Error: " . $ex->getMessage();
            return response()->json($salida, 500);
        }
    }


    // 🔧 Helper privado para normalizar códigos
    private function normalizeOrderCode($code): string {
        return preg_replace('/\s+/', '', $code);
    }

    // 🔧 Helper privado para verificar coincidencia de códigos
    private function matchesOrderCode($candidate, $input): bool {
        return $this->normalizeOrderCode($candidate) === $this->normalizeOrderCode($input);
    }

    public function searchDB($order_code){
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        // 🚫 Validación de roles
        if(
            !Auth::user()->hasRole("SupCalidad") &&
            !Auth::user()->hasRole("Mezcla") &&
            !Auth::user()->hasRole("Calidad") &&
            !Auth::user()->hasRole("Produccion") &&
            !Auth::user()->hasRole("JefeProduccion") &&
            !Auth::user()->hasRole("Muestreo") &&
            !Auth::user()->hasRole("SupCalidad") &&
            !Auth::user()->hasRole("JefeControlCalidad") &&
            !Auth::user()->hasRole("AuxControlCalidad")
        ){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        // 🔎 Normalizar código para BD
        $normalizedDBCode = $this->normalizeOrderCode($order_code);

        // Buscar en BD
        $order = MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedDBCode])->first();

        // 🚀 Si no está en BD y es JefeProducción, ir a API
        if(!$order && Auth::user()->hasRole("JefeProduccion")){
            $salida["data"] = ["origin" => "API", "order" => null];

            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                $salida["msg"] = "Error al conectar con la API";
                return $salida;
            }

            // 🧹 Limpieza de respuesta
            $body = $response->body();
            $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);
            $body = preg_replace('/^\x{FEFF}/u', '', $body);
            $body = preg_replace('/[\x00-\x1F\x7F]/u', '', $body);

            $items = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error("json_decode falló: " . json_last_error_msg());
                $cleanBody = preg_replace('/[^[:print:]\s]/u', '', $body);
                $items = json_decode($cleanBody, true);
            }

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                $salida["msg"] = "Error: JSON inválido → " . json_last_error_msg();
                $salida["data"]["raw"] = substr($body,0,1000);
                return $salida;
            }

            // 🔍 Buscar coincidencia en API (versátil)
            foreach ($items as $el) {
                $e = (object)$el;
                if ($this->matchesOrderCode($e->num, $order_code)) {
                    $order = $e;
                    $salida["code"] = 1;
                    $salida["msg"]  = "Processed Successfully";
                    $salida["data"] = ["origin" => "API", "order" => $order];
                    return $salida;
                }
            }

            $salida["msg"] = "No se encontró la orden en la API";
            return $salida;
        }

        // 🚫 Si no está en BD y no es JefeProducción
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        // ✅ Si está en BD → formatear fechas y cargar materiales
        foreach (['pesaje_inicio','pesaje_fin'] as $campo) {
            if ($order->$campo) {
                $order->$campo = Carbon::parse($order->$campo)->format('Y-m-d H:i:s');
            }
        }

        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"]  = "Processed Successfully";
        $salida["data"] = ["origin" => "DB", "order" => $order];

        return $salida;
    }


    public function authorizeOrder($id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("SupCalidad")){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $order = MixOrder::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }
        //Hace referencia a que la mezcla ya fue revisada
        if($order->status != -1){
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }

        $order->status = 4;
        $order->user_autoriza = session('user_cur_fullname');

        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema en la aprobacion";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    public function revisarOrder(Request $request, $id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];


        // Buscar la orden
        $order = MixOrder::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        // Verificar el estado actual de la orden
        if($order->status != 3){
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }

        // Procesar las revisiones
        $revisiones_filter = [];
        foreach($request->revisiones as $revs){
            array_push($revisiones_filter,[
                "username" => session('user_cur_fullname'),
                "date" => $revs["date"],
                "firma" => session('user_cur_fullname')
            ]);
        }

        // Guardar las revisiones
        $order->revisiones = json_encode($revisiones_filter);

        // Actualizar el estado de la orden a 4 (autorizada)
        $order->status = 4;

        // Registrar quien autoriza la orden
        $order->user_autoriza = session('user_cur_fullname');

        // Intentar guardar los cambios
        if(!$order->save()){
            $salida["msg"] = "Ocurrió un problema en la autorización";
            return $salida;
        }

        // Refrescar la orden y cargar los materiales
        $order->refresh();
        $order->load('materials');

        // Retornar la respuesta exitosa
        $salida["code"] = 1;
        $salida["msg"] = "Orden autorizada y revisada correctamente";
        $salida["data"] = $order;

        return $salida;
    }



    public function init(Request $request, $id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("Mezcla")){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        //Usar Clase Validator para fecha y campos aqui

        $order = MixOrder::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }


        //"lot_num"               => "required|numeric|min:0",
        $validador = Validator::make($request->all(), [
            "lot_num"               => "required",
            "init_datetime"         => "required",
        ]);

        if($validador->fails()){
            $salida["msg"] = "Error en validación de campos (" . $validador->errors()->first() . ")";
            return $salida;
        }


        // Para dar inicio a la mezcla debe estar con estado 4, pesaje aprobado. Ref. cambios - PI-50
        if($order->status != 4){
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }


        

        $order->status = 5;

        $order->datetime_init = $request->init_datetime;
        $order->lot_num = $request->lot_num;
        // $order->revisiones = json_encode($revisiones_filter);
        $order->user_recibe = session('user_cur_fullname');

        /**
         * 🔹 NUEVO: guardar snapshot del análisis de agua actual
         * Toma el registro con estado = 1 (activo) de resultado_analisis_agua
         * y lo guarda como JSON en mix_orders.analisis_agua
         */
        $analisisAgua = ResultadoAnalisisAgua::where('estado', 1)
                        ->orderByDesc('id')
                        ->first();

        if (!$analisisAgua) {
            $order->analisis_agua = null;
        } else {
            $order->analisis_agua = [
                'id'                      => $analisisAgua->id,
                'resultado_ph'            => $analisisAgua->resultado_ph,
                'resultado_conductividad' => $analisisAgua->resultado_conductividad,
                'resultado_cloro_libre'   => $analisisAgua->resultado_cloro_libre,
                'observaciones'           => $analisisAgua->observaciones,
                'fecha_registro'          => $analisisAgua->fecha_registro,
                'usuario_crea'            => $analisisAgua->usuario_crea,
            ];
        }


        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema en iniciar mezcla";
            return $salida;
        }



        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    public function registrarCambioDeLote(Request $request, $material_id)
    {
        $material = Material::findOrFail($material_id);
        $order = MixOrder::findOrFail($material->mix_order_id);

        $usuario = Auth::user()->name;
        $fecha = now()->format('Y-m-d');
        $obs = '';
        $loteModificado = false;

        // Obtener contador de cambios anteriores
        $asteriskCount = $order->lot1_changes + 1;
        $asterisks = str_repeat('*', $asteriskCount);

        $valorAnteriorLot1 = $material->lot1;

        // Cambios en LOTE 1 (con asteriscos)
        // if ($request->has('lot1') && $request->lot1 !== $material->old_lot1) {
        //     $obs .= "lot1-" . $request->lot1 . "$asterisks, ";
        //     $obs .= "lot1-" . $valorAnteriorLot1 . "$asterisks, ";
        //     $obs .= "$usuario, $fecha\n";

        //     $material->old_lot1 = $valorAnteriorLot1;
        //     $material->lot1 = $request->lot1 . $asterisks;
        //     $loteModificado = true;
        // }

        if ($request->has('lot1') && $request->lot1 !== $material->old_lot1) {
            $order->lot1_changes += 1; // ✅ Incrementar contador solo si cambia lot1
        
            $asterisks = str_repeat('*', $order->lot1_changes);
            $obs .= "lot1-" . $request->lot1 . "$asterisks, ";
            $obs .= "lot1-" . $material->lot1 . "$asterisks, ";
            $obs .= "$usuario, $fecha\n";
        
            $material->old_lot1 = $material->lot1;
            $material->lot1 = $request->lot1 . $asterisks;
            $loteModificado = true;
        }

        // Cambios en LOTE 2 (sin asteriscos)
        if ($request->has('lot2') && $request->lot2 !== $material->old_lot2) {
            $obs .= "lot2-" . $request->lot2 . ", ";
            $obs .= "lot2-" . $material->old_lot2 . ", ";
            $obs .= "$usuario, $fecha\n";

            $material->old_lot2 = $material->lot2;
            $material->lot2 = $request->lot2;
            $loteModificado = true;
        }

        if ($loteModificado) {
            $material->entrega1 = 0;
        }

        DB::beginTransaction();
        try {
            $material->modified_by = $usuario;
            $material->modification_date = now();
            $material->save();

            if ($loteModificado) {
                $order->lot1_changes += 1;      // Incrementa contador
                $order->status = 2;             // Cambia status
            }

            if (!empty($obs)) {
                $order->observaciones = trim(($order->observaciones ?? '') . "\n" . $obs);
            }

            $order->save();

            DB::commit();

            return response()->json([
                "code" => 1,
                "msg" => "Actualización registrada correctamente",
                "data" => [
                    "material" => [
                        "id" => $material->id,
                        "lot1" => $material->lot1,
                        "lot2" => $material->lot2,
                        "entrega1" => $material->entrega1
                    ],
                    "observaciones" => $order->observaciones
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["code" => 0, "msg" => "Error: " . $e->getMessage()]);
        }
    }
    
    


    public function upwater(Request $request,$id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("SupCalidad")){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $order = MixOrder::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        $validator = Validator::make($request->all(),[
            // "water_check" => "required|boolean",
            // "water_date" => "required|date",
            // "observaciones" => "required|string"
        ]);

        // if($validator->fails()){
        //     $salida["msg"] = "Error en validacion de campos (" .$validator->errors()->first().")";
        //     return $salida;
        // }
        $order->water_firma = session('user_cur_fullname');

        // Mezclar las observaciones que vengan desde esta pantalla
        if ($request->has('observaciones')) {
            $order->observaciones = $this->mergeObservations(
                $order->observaciones,
                $request->observaciones
            );
        }
        // $order->water_firma = session('user_cur_fullname');
        // // $order->water_check = $request->water_check;
        // // $order->water_date = $request->water_date;
        // $order->observaciones = $request->observaciones;

        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema en la aprobacion";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    public function approvePesaje(Request $request,$id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];


        $order = MixOrder::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        $order->pesaje_fin = now('America/El_Salvador')->format('Y-m-d H:i:s');
        $order->status = 3;

        if(!$order->save()){
            $salida["msg"] = "Ocurrio un problema en la aprobacion";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    //Busqueda exclusiva para el rol de Materia prima
    //Carga consultando API de lo contrario buscar en DB
    public function search($order_code)
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        // Verificación de permisos para Materia Prima
        if (!Auth::user()->hasRole("MateriaPrima")) {
            $salida["msg"] = "Operación denegada";
            \Log::warning('Acceso denegado para el usuario. Rol requerido: MateriaPrima');
            return $salida;
        }

        \Log::info("Iniciando búsqueda de orden: " . $order_code);

        // Normalizar el código ingresado
        $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);

        // Inicializar búsqueda en la base de datos local
        $salida["data"] = ["origin" => "DB", "order" => null];
        $order = MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode])->first();

        // Si no se encuentra en la BD, consultar la API
        if (!$order) {
            $salida["data"]["origin"] = "API";

            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";
            $response = Http::withoutVerifying()->get($url);

            // Validación de respuesta HTTP
            if ($response->failed()) {
                \Log::error("Error en la petición a la API. Código de estado: " . $response->status());
                $salida["msg"] = "Error al conectar con la API.";
                return $salida;
            }

            $body = $response->body();

            // Logs útiles (evita loguear TODO si es enorme, pero aquí lo mantengo como lo tenías)
            \Log::info('API Response length: ' . strlen($body));
            \Log::info('API Response (raw): ' . $body);
            file_put_contents(storage_path('logs/debug.log'), 'API Response length: ' . strlen($body) . "\n", FILE_APPEND);
            file_put_contents(storage_path('logs/debug.log'), 'API Response (raw): ' . $body . "\n", FILE_APPEND);

            /**
             * ✅ PARSEO ROBUSTO SIN PERDER TILDES
             * - Quita BOM
             * - Recorta basura antes/después del JSON (HTML/warnings/texto extra)
             * - Quita SOLO caracteres de control
             * - Asegura UTF-8
             * - json_decode tolerante a bytes inválidos
             */

            // 1) Quitar BOM
            $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);

            // 2) Encontrar inicio del JSON real ({ o [)
            $firstArr = strpos($body, '[');
            $firstObj = strpos($body, '{');

            if ($firstArr === false && $firstObj === false) {
                \Log::error("La respuesta no contiene '[' ni '{'. Posible HTML/warning.");
                \Log::error("Snippet inicio: " . substr($body, 0, 250));
                file_put_contents(storage_path('logs/debug.log'), "No contiene JSON. Snippet: " . substr($body, 0, 500) . "\n", FILE_APPEND);
                $salida["msg"] = "Error crítico: La API no devolvió JSON.";
                return $salida;
            }

            $start = ($firstArr === false) ? $firstObj : (($firstObj === false) ? $firstArr : min($firstArr, $firstObj));

            // 3) Encontrar fin del JSON real (} o ])
            $lastArr = strrpos($body, ']');
            $lastObj = strrpos($body, '}');
            $end = max($lastArr !== false ? $lastArr : -1, $lastObj !== false ? $lastObj : -1);

            if ($end < $start) {
                \Log::error("No se pudo determinar el fin del JSON (JSON incompleto).");
                \Log::error("Snippet inicio: " . substr($body, 0, 250));
                file_put_contents(storage_path('logs/debug.log'), "JSON incompleto. Snippet: " . substr($body, 0, 500) . "\n", FILE_APPEND);
                $salida["msg"] = "Error crítico: JSON incompleto desde la API.";
                return $salida;
            }

            // 4) Extraer solo el JSON “puro”
            $jsonRaw = substr($body, $start, ($end - $start) + 1);

            // 5) Eliminar SOLO caracteres de control (no afecta tildes)
            $jsonRaw = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $jsonRaw);

            // 6) Asegurar UTF-8 (json_decode lo necesita)
            if (!mb_check_encoding($jsonRaw, 'UTF-8')) {
                $enc = mb_detect_encoding($jsonRaw, ['UTF-8', 'Windows-1252', 'ISO-8859-1'], true) ?: 'Windows-1252';
                $jsonRaw = mb_convert_encoding($jsonRaw, 'UTF-8', $enc);
            }

            // 7) Decodificar JSON con tolerancia
            $flags = 0;
            if (defined('JSON_INVALID_UTF8_SUBSTITUTE')) $flags |= JSON_INVALID_UTF8_SUBSTITUTE;

            $items = json_decode($jsonRaw, true, 512, $flags);

            // 8) Si aún falla, último intento: iconv ignorando bytes corruptos
            if (json_last_error() !== JSON_ERROR_NONE) {
                $iconv = @iconv('UTF-8', 'UTF-8//IGNORE', $jsonRaw);
                if ($iconv !== false) {
                    $items = json_decode($iconv, true, 512, $flags);
                }
            }

            // 9) Si falla definitivamente
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error('Error JSON API: ' . json_last_error_msg());
                \Log::error('Snippet JSON: ' . substr($jsonRaw, 0, 250));
                file_put_contents(storage_path('logs/debug.log'), "JSON Error: " . json_last_error_msg() . "\n", FILE_APPEND);
                file_put_contents(storage_path('logs/debug.log'), "Snippet JSON: " . substr($jsonRaw, 0, 500) . "\n", FILE_APPEND);

                $salida["msg"] = "Error crítico: La API devolvió datos ilegibles.";
                return $salida;
            }

            // Log del código de orden que se está buscando
            \Log::info('Buscando orden con código: ' . $order_code);
            file_put_contents(storage_path('logs/debug.log'), 'Buscando orden con código: ' . $order_code . "\n", FILE_APPEND);

            // Buscar la orden en los datos obtenidos de la API
            $found = false;
            foreach ($items as $el) {
                $e = (object)$el;

                \Log::info('Orden en API: ' . json_encode($e, JSON_UNESCAPED_UNICODE));
                file_put_contents(
                    storage_path('logs/debug.log'),
                    'Orden en API: ' . json_encode($e, JSON_UNESCAPED_UNICODE) . "\n",
                    FILE_APPEND
                );

                if (preg_replace('/\s+/', '', $e->num ?? '') == $normalizedOrderCode) {
                    $order = $e;
                    $found = true;

                    \Log::info('Orden encontrada: ' . json_encode($order, JSON_UNESCAPED_UNICODE));
                    file_put_contents(
                        storage_path('logs/debug.log'),
                        'Orden encontrada: ' . json_encode($order, JSON_UNESCAPED_UNICODE) . "\n",
                        FILE_APPEND
                    );

                    break;
                }
            }

            if (!$found) {
                \Log::warning("No se encontró la orden con el código: {$order_code}");
                file_put_contents(storage_path('logs/debug.log'), "No se encontró la orden con el código: {$order_code}\n", FILE_APPEND);
                $salida["msg"] = "No se encontró la orden en la API.";
                return $salida;
            }

        } else {
            // Si se encuentra en la base de datos, cargar materiales relacionados
            $order->load('materials');
            \Log::info("Orden encontrada en la base de datos: " . json_encode($order, JSON_UNESCAPED_UNICODE));
        }

        // Formatear la fecha
        if (isset($order->date)) {
            $order->date = Carbon::parse($order->date)->format('Y-m-d H:i:s');
        }

        // Respuesta exitosa
        $salida["code"] = 1;
        $salida["msg"]  = "Processed Successfully";
        $salida["data"]["order"] = $order;

        return $salida;
    }



      /**
     * Devuelve las observaciones partidas por línea con su id_linea
     */
    public function getObservacionesPorLineas($orderId)
    {
            $salida = [
                "code" => 0,
                "msg"  => "",
                "data" => null
            ];

            try {
                $sql = <<<SQL
    WITH RECURSIVE cte AS (
    -- 1. Primera línea
    SELECT 
        id,
        observaciones AS full_text,
        TRIM(SUBSTRING_INDEX(observaciones, '\n', 1)) AS linea,
        SUBSTRING(
            observaciones,
            CHAR_LENGTH(SUBSTRING_INDEX(observaciones, '\n', 1)) 
            + CASE 
                WHEN INSTR(observaciones, '\r\n') > 0 THEN 3 
                ELSE 2 
              END
        ) AS resto
    FROM mix_orders
    WHERE id = :order_id

    UNION ALL

    -- 2. Líneas siguientes
    SELECT
            id,
            full_text,
            TRIM(SUBSTRING_INDEX(resto, '\n', 1)) AS linea,
            SUBSTRING(
                resto,
                CHAR_LENGTH(SUBSTRING_INDEX(resto, '\n', 1)) 
                + CASE 
                    WHEN INSTR(resto, '\r\n') > 0 THEN 3 
                    ELSE 2 
                END
            ) AS resto
        FROM cte
        WHERE resto <> ''
    )

    SELECT
        id,
        linea,
        DATE_FORMAT(
            STR_TO_DATE(
                SUBSTRING(
                    linea,
                    INSTR(linea, '(') + 1,
                    INSTR(linea, ')') - INSTR(linea, '(') - 1
                ),
                '%Y-%m-%d %H:%i:%s'
            ),
            '%d%m%Y%H%i%s'
        ) AS id_linea
    FROM cte
    WHERE 
        linea <> ''
        AND INSTR(linea, '(') > 0
        AND INSTR(linea, ')') > INSTR(linea, '(');
    SQL;

                $rows = DB::select($sql, [
                    'order_id' => $orderId
                ]);

                $salida["code"] = 1;
                $salida["msg"]  = "Processed Successfully";
                $salida["data"] = $rows;

            } catch (\Exception $e) {
                \Log::error("Error en getObservacionesPorLineas: ".$e->getMessage());
                $salida["msg"] = "Error: " . $e->getMessage();
            }

            return response()->json($salida);
    }

    /**
     * Agrega una nueva línea de observación o actualiza una existente
     * usando el id_linea (ddmmyyyyhhmmss) que devuelve getObservacionesPorLineas.
     *
     * Formato final de la línea:
     *   Usuario (YYYY-mm-dd HH:ii:ss): texto...
     */
    /**
     * Procesa las observaciones del frontend.
     * - Si una línea ya tiene formato "Usuario (Fecha): Texto", la conserva.
     * - Si una línea NO tiene ese formato (es nueva o modificada sin timestamp), le agrega "Usuario (Fecha): ".
     * - Ignora $dbText (la versión en BD) para permitir edición/borrado libre desde el frontend ("Save what you see").
     */
    private function processObservations(string $dbText, string $frontendText): string
    {
        // Normalizar saltos de línea
        $frontendText = str_replace("\r\n", "\n", $frontendText);
        $lines = preg_split('/\n+/', $frontendText);
        
        $resultLines = [];
        
        foreach ($lines as $rawLine) {
            $rawLine = trim($rawLine);
            if ($rawLine === '') {
                continue;
            }

            // Regex para detectar "Usuario (YYYY-MM-DD HH:mm:ss): "
            // Se asume que si cumple este patrón, es una línea existente/válida.
            if (preg_match('/^(.*?\(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\): )(.*)$/u', $rawLine)) {
                $resultLines[] = $rawLine;
            } else {
                // No tiene timestamp válido -> es nueva o editada rompiendo el formato.
                // Agregamos prefijo actual.
                $usuario = session('user_cur_fullname') ?? (Auth::user()->name ?? 'N/D');
                $now = now('America/El_Salvador')->format('Y-m-d H:i:s');
                $prefix = "{$usuario} ({$now}): ";
                
                // Si el usuario solo puso el texto, lo concatenamos.
                $resultLines[] = $prefix . $rawLine;
            }
        }
        
        return implode("\n", $resultLines);
    }


     /**
     * Fusiona observaciones actuales (BD) con las nuevas (frontend)
     * Reglas:
     *  - Si id_linea existe en BD y frontend:
     *      - Si el texto es igual -> se deja igual
     *      - Si el texto cambió -> se actualiza la línea con el texto nuevo
     *  - Si id_linea existe sólo en frontend -> se considera línea nueva y se agrega
     *  - Si id_linea existe sólo en BD -> la conservamos (no permitimos borrado)
     */

    

    public function updateObservaciones(Request $request, $id)
    {
        $order = MixOrder::findOrFail($id);

        // Texto que viene del frontend (todas las observaciones juntas)
        $nuevoTexto = (string) $request->input('observaciones', '');

        // Texto actual en BD
        $textoActual = (string) $order->observaciones;

        // Fusionar según reglas (ahora usa processObservations)
        $textoFusionado = $this->processObservations($textoActual, $nuevoTexto);

        // Si no cambió nada, no actualizamos
        if (trim($textoFusionado) === trim($textoActual)) {
            return response()->json([
                'code' => 0,
                'msg'  => 'Sin cambios en observaciones',
                'data' => [
                    'observaciones' => $textoActual,
                    'actualizado'   => false,
                ]
            ]);
        }

        // Guardar solo si hay cambios
        $order->observaciones = $textoFusionado;
        $order->save();

        return response()->json([
            'code' => 0,
            'msg'  => 'Observaciones actualizadas',
            'data' => [
                'observaciones' => $order->observaciones,
                'actualizado'   => true,
            ]
        ]);
    }


    public function saveOrUpdate(Request $request){
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        $validator = Validator::make($request->all(),[
            "date" => "required|date",
            "num_id" => "required|string",
            "product_code" => "required",
            "product_name" => "required",
            "lot_size" => "required|numeric",
            "cod_formula_master" => "required",
            "revisiones" => "required|array",
            "materials.*.stock" => "required|numeric|min:0",
            "materials.*.almacen" => "required|numeric|min:0",
        ]);

        if($validator->fails()){
            $salida["msg"] = "Error en validacion de campos (" .$validator->errors()->first().")";
            return $salida;
        }

        DB::beginTransaction();
        try {
            // 👉 Buscar o crear orden
            if($request->order_id != 0){
                $order = MixOrder::find($request->order_id);
            }else{
                $order = new MixOrder();
            }

            if (is_null($order->pesaje_inicio)) {
                $order->pesaje_inicio = now('America/El_Salvador')->format('Y-m-d H:i:s');
            }

            $materials_count = count($request->materials ?? []);

            // Campos base
            $order->order_date         = $request->date;
            $order->num_id             = preg_replace('/\s+/', '', $request->num_id);
            $order->product_code       = $request->product_code;
            $order->product_name       = $request->product_name;
            $order->lot_size           = $request->lot_size;
            $order->cod_formula_master = $request->cod_formula_master;
            $order->materials          = $materials_count;
            $order->revisiones         = json_encode($request->revisiones);
            
            // 🔹 Guardar especificaciones si vienen en el request (desde API externa)
            if ($request->has('especificaciones_ph')) {
                $order->especificaciones_ph = $request->especificaciones_ph;
            }
                if ($request->has('especificaciones_viscosidad')) {
                    $order->especificaciones_viscosidad = $request->especificaciones_viscosidad;
                }
                if ($request->has('especificaciones_densidad')) {
                    $order->especificaciones_densidad = $request->especificaciones_densidad;
                }
    
                // 👇 Permitir que MateriaPrima o SupCalidad trabajen observaciones
                if (Auth::user()->hasRole("MateriaPrima") || Auth::user()->hasRole("SupCalidad")) {
    
                    // Solo MateriaPrima llena user_entrega y status (si aún no tiene)
                    if (empty($order->user_entrega) && Auth::user()->hasRole("MateriaPrima")) {
                        $order->user_entrega = session('user_cur_fullname');
                        $order->status       = 2;
                    }
    
                    if ($request->filled('observations')) {
                        $order->observaciones = $this->processObservations(
                            (string) $order->observaciones,
                            (string) $request->input('observations')
                        );
                    }
                }

                // 🔹 Lógica verified_by: Si es SupCalidad, estatus 2, campo vacío y al menos un material verificado (entrega1=1) EXCEPTO AGUA
                if (Auth::user()->hasRole("SupCalidad") && $order->status == 2 && empty($order->verified_by)) {
                     $hasVerifiedMaterial = false;
                     foreach ($request->materials as $mat) {
                         // Normalizar código quitando espacios, por si acaso
                         $code = isset($mat['code']) ? preg_replace('/\s+/', '', $mat['code']) : '';
                         
                         // Ignorar Agua (809909900100)
                         if (isset($mat['entrega1']) && $mat['entrega1'] == 1 && $code !== '809909900100') {
                             $hasVerifiedMaterial = true;
                             break;
                         }
                     }
                     
                     if ($hasVerifiedMaterial) {
                         $order->verified_by = session('user_cur_fullname');
                     }
                }
    
    
                // 🔹 FIN BLOQUE NUEVO
    
                $order->save();

            // 👉 Guardar / actualizar materiales
            foreach ($request->materials as $target) {
                $target = (object)$target;

                if($target->material_id != 0){
                    $mats = Material::find($target->material_id); // actualizar
                }else{
                    $mats = new Material();                       // nuevo
                }

                if($mats == null){
                    throw new \Exception("Inconsistencia en los materiales");
                }

                $mats->code            = preg_replace('/\s+/', '', $target->code);
                $mats->description     = $target->description;
                $mats->required_amount = $target->required_amount;

                if(isset($target->amount1) && isset($target->amount2)){
                    $mats->amount1 = $target->amount1;
                    $mats->amount2 = $target->amount2;
                }

                $mats->unit        = $target->unit;
                $mats->stock       = $target->stock;
                $mats->almacen     = $target->almacen;
                $mats->entrega1    = $target->entrega1;
                $mats->lot1        = $target->lot1;
                $mats->entrega2    = $target->entrega2;
                $mats->lot2        = $target->lot2;
                $mats->mix_order_id = $order->id;

                $mats->save();
            }

            $order->refresh();
            DB::commit();

            $salida["code"] = 1;
            $salida["msg"]  = "Processed Successfully";
            $salida["data"] = $order->load('materials');
        } catch(\Exception $ex) {
            DB::rollback();
            $salida['msg'] = "Error: " . $ex->getMessage()." en linea ".$ex->getLine();
        }

        return $salida;
    }



   // Ruta para actualizar solo los campos de MixOrder
    public function updateOrderMaterialsReceived(Request $request, $id) {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        DB::beginTransaction();
        try {
            $order = MixOrder::with('materials')->findOrFail($id);
            
            // ✅ Actualizar estado de la orden
            $order->status_receive_materials = 1;
            $order->materials_received_by   = session('user_cur_fullname');
            
            // ✅ Guardar los cambios en la orden
            $order->save();

            DB::commit();
            
            $salida["code"] = 1;
            $salida["msg"]  = "Orden actualizada correctamente";
            $salida["data"] = [
                'order'     => $order,
                'materials' => $order->materials()->get()
            ];

        } catch (\Exception $ex) {
            DB::rollback();
            $salida['msg'] = "Error al actualizar recepción de materiales: " . $ex->getMessage();
            return response()->json($salida, 500);
        }

        return response()->json($salida);
    }



    // Ruta para actualizar los materiales
    public function updateMaterialsDelivery(Request $request) {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        // Validación de campos requeridos
        $validator = Validator::make($request->all(), [
            "order_id" => "required|integer|exists:mix_orders,id",
            "materials" => "required|array",
            "materials.*.material_id" => "required|integer|exists:materials,id,mix_order_id,$request->order_id",
            "materials.*.entrega3" => "required|boolean"
        ], [
            'materials.*.material_id.exists' => 'El material no pertenece a esta orden'
        ]);

        if($validator->fails()) {
            $salida["msg"] = "Error en validación: " . $validator->errors()->first();
            return response()->json($salida, 422);
        }

        DB::beginTransaction();
        try {
            $order = MixOrder::findOrFail($request->order_id);
            
            // Actualizar cada material
            $updatedMaterials = [];
            foreach ($request->materials as $materialData) {
                $material = Material::where('id', $materialData['material_id'])
                                ->where('mix_order_id', $request->order_id)
                                ->firstOrFail();

                $material->entrega3 = $materialData['entrega3'];
                $material->updated_at = now();
                $material->save();

                $updatedMaterials[] = $material;
            }

            DB::commit();
            
            $salida["code"] = 1;
            $salida["msg"] = "Entrega de materiales actualizada correctamente";
            $salida["data"] = [
                'order' => $order,
                'materials' => $updatedMaterials
            ];

        } catch (\Exception $ex) {
            DB::rollback();
            $salida['msg'] = "Error al actualizar entrega de materiales: " . $ex->getMessage();
            return response()->json($salida, 500);
        }

        return response()->json($salida);
    }

    public function finish(Request $request, $id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("Mezcla")){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        $order = MixOrder::find($id);
        if(!$order){
            $salida["msg"] = "La orden no fue encontrada";
            return $salida;
        }

        $validador = Validator::make($request->all(), [
            "real_performance" => "required",
            "end_datetime"     => "required"
        ]);

        if($validador->fails()){
            $salida["msg"] = "Error en validación de campos (" . $validador->errors()->first() . ")";
            return $salida;
        }

        if($order->status != 5 && $order->status != 6){
            $salida["msg"] = "Inconsistencia de estado";
            return $salida;
        }

        // Guardar datos de finalización
        $order->datetime_end     = $request->end_datetime;
        $order->real_performance = $request->real_performance;
        $order->user_finish      = session('user_cur_fullname');
        $order->finish_order_at  = now();

        // 👇 Siempre marcar como finalizada (estado 7)
        $order->status = 7;
        // Si no hay observaciones del operario al finalizar, dejar “N/A”
        $obs = trim((string) $order->observaciones);

        if ($obs === '') {
            $order->observaciones = 'N/A';
        } elseif (str_contains($obs, '|')) {
            // Caso: solo hay bitácora automática pero nada manual
            [$manual, $bitacora] = array_map('trim', explode('|', $obs, 2));
            if ($manual === '') {
                $order->observaciones = 'N/A | ' . $bitacora;
            }
        }

        if(!$order->save()){
            $salida["msg"] = "Ocurrió un problema en la finalización";
            return $salida;
        }

        $order->refresh();
        $order->load('materials');

        $salida["code"] = 1;
        $salida["msg"]  = "Processed Successfully";
        $salida["data"] = $order;

        return $salida;
    }

    public function autorizefinished(Request $request, $id )
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("JefeProduccion")){
            $salida["msg"] = "Operación denegada";
            \Log::warning("❌ Acceso denegado a autorizefinished por el usuario: " . Auth::user()->name);
            return $salida;
        }

        DB::beginTransaction();
        try {
            \Log::info("🔎 Payload recibido en autorizefinished:", $request->all());

            $order = null;
            if ($request->input('order_id', 0) != 0) {
                $order = MixOrder::find($request->input('order_id'));
                \Log::info("📂 Buscando orden por ID: {$request->order_id} → " . ($order ? "ENCONTRADA" : "NO ENCONTRADA"));
            }

            if(!$order){
                // 👉 Validar datos mínimos antes de crear
                if (!$request->filled('num_id') || !$request->filled('product_code') || !$request->filled('product_name')) {
                    throw new \Exception("Faltan datos obligatorios para crear la orden (num_id, product_code, product_name).");
                }

                $order = new MixOrder();

                // 📅 Normalizar fecha: si no viene, usar now()
                $date = $request->input('date');
                if ($date) {
                    try {
                        $order->order_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d H:i:s');
                    } catch (\Exception $e) {
                        $order->order_date = now('America/El_Salvador');
                    }
                } else {
                    $order->order_date = now('America/El_Salvador');
                }

                $order->num_id             = preg_replace('/\s+/', '', $request->input('num_id'));
                $order->product_code       = $request->input('product_code');
                $order->product_name       = $request->input('product_name');
                $order->lot_size           = $request->input('lot_size', 0);
                $order->cod_formula_master = $request->input('cod_formula_master', "");
                $order->revisiones         = json_encode($request->input('revisiones', []));
                $order->materials          = count($request->input('materials', []));
                // $order->pesaje_inicio      = now('America/El_Salvador')->format('Y-m-d H:i:s');
                $order->status             = 2;

                \Log::info("🆕 Creando nueva orden desde API con num_id={$order->num_id}, product_code={$order->product_code}");
            }

            // 👇 Siempre registrar autorización
            $order->user_autoriza_finish  = session('user_cur_fullname');
            $order->autorize_finish_order = now('America/El_Salvador');

            $order->save();
            \Log::info("💾 Orden guardada/actualizada con ID={$order->id}");

            // 🔄 Guardar materiales del request
            $materials = $request->input('materials', []);
            foreach ($materials as $mat) {
                $material = isset($mat['material_id']) && $mat['material_id'] != 0
                    ? Material::find($mat['material_id'])
                    : new Material();

                if(!$material){
                    throw new \Exception("Inconsistencia en los materiales (ID={$mat['material_id']})");
                }

                $material->code            = preg_replace('/\s+/', '', $mat['code']);
                $material->description     = $mat['description'];
                $material->required_amount = $mat['required_amount'];
                $material->unit            = $mat['unit'];
                $material->stock           = $mat['stock'];
                $material->almacen         = $mat['almacen'];
                $material->entrega1        = $mat['entrega1'] ?? false;
                $material->lot1            = $mat['lot1'] ?? "";
                $material->entrega2        = $mat['entrega2'] ?? false;
                $material->lot2            = $mat['lot2'] ?? "";
                $material->mix_order_id    = $order->id;
                $material->save();
            }
            \Log::info("📦 Materiales procesados: " . count($materials));

            $order->refresh();
            $order->load('materials');

            DB::commit();

            $salida["code"] = 1;
            $salida["msg"]  = "Processed Successfully";
            $salida["data"] = $order;

            \Log::info("✅ Proceso finalizado con éxito para la orden ID={$order->id}");
        } catch(\Exception $ex) {
            DB::rollBack();
            $salida["msg"] = "Error: " . $ex->getMessage()." en línea ".$ex->getLine();

            \Log::error("🔥 Error en autorizefinished: " . $ex->getMessage(), [
                'linea' => $ex->getLine(),
                'trace' => $ex->getTraceAsString()
            ]);
        }

        return $salida;
    }




  

    public function changeLotsBulk(Request $request)
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        // 🔐 Validación de roles
        if (!Auth::user()->hasRole("MateriaPrima") && !Auth::user()->hasRole("SupCalidad")) {
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        // ✅ Validación de datos
        $validator = Validator::make($request->all(), [
            "changes" => "required|array",
            "changes.*.material_id" => "required|integer|exists:materials,id",
            "changes.*.new_lot" => "required|string|max:100",
            "changes.*.amount1" => "nullable|numeric|min:0",
            "changes.*.amount2" => "nullable|numeric|min:0"
        ]);

        if ($validator->fails()) {
            $salida["msg"] = "Error en validación (" . $validator->errors()->first() . ")";
            return $salida;
        }

        DB::beginTransaction();

        try {
            $materialesActualizados = [];
            $orderMap = [];
            $cambiosAplicados = 0;

            // 🔁 Procesar cada cambio recibido
            foreach ($request->changes as $change) {
                $material = Material::findOrFail($change['material_id']);
                $orderId = $material->mix_order_id;

                $oldLot = $material->lot1;
                $currentBaseLot = preg_replace('/\*+$/', '', $material->lot1);
                $newBaseLot = preg_replace('/\*+$/', '', $change['new_lot']);

                $originalAmount1 = $material->amount1;
                $originalAmount2 = $material->amount2;
                $newAmount1 = $change['amount1'] ?? null;
                $newAmount2 = $change['amount2'] ?? null;

                $lotChanged = $currentBaseLot !== $newBaseLot;
                $amountChanged = ($newAmount1 !== null && floatval($originalAmount1) !== floatval($newAmount1)) ||
                                ($newAmount2 !== null && floatval($originalAmount2) !== floatval($newAmount2));

                if (!$lotChanged && !$amountChanged) continue;

                $orderMap[$orderId][] = $material->id;

                // 🧾 Registrar cambio de lote
                if ($lotChanged) {
                    $material->modification_count = ($material->modification_count ?? 0) + 1;
                    $newLotWithAsterisks = $newBaseLot . str_repeat('*', $material->modification_count);

                    $material->old_lot1 = $oldLot;
                    $material->lot1 = $newLotWithAsterisks;
                    $material->entrega1 = 0;
                    $material->modified_by = Auth::user()->name;
                    $material->modification_date = now();

                    if (array_key_exists('amount1', $change)) {
                        $material->amount1 = $newAmount1;
                    }
                    if (array_key_exists('amount2', $change)) {
                        $material->amount2 = $newAmount2;
                    }

                    // 🕓 Agregar historial
                    $historial = json_decode($material->lot_changes_history ?? '[]', true);
                    $historial[] = [
                        'antiguo_valor' => $oldLot,
                        'nuevo_valor'   => $newLotWithAsterisks,
                        'usuario'       => Auth::user()->name,
                        'fecha'         => now()->toDateTimeString(),
                    ];
                    $material->lot_changes_history = json_encode($historial);
                } else {
                    // Solo cambió cantidad
                    if (array_key_exists('amount1', $change)) {
                        $material->amount1 = $newAmount1;
                    }
                    if (array_key_exists('amount2', $change)) {
                        $material->amount2 = $newAmount2;
                    }
                }

                $material->save();

                $materialesActualizados[] = [
                    'id' => $material->id,
                    'material_id' => $material->id,
                    'lot1' => $material->lot1,
                    'old_lot1' => $material->old_lot1,
                    'modified_by' => $material->modified_by,
                    'modification_date' => $material->modification_date,
                    'modification_count' => $material->modification_count,
                    'bitacora' => json_decode($material->lot_changes_history ?? '[]'),
                    'code' => $material->code,
                    'entrega1' => $material->entrega1,
                    'amount1' => $material->amount1,
                    'amount2' => $material->amount2,
                    'entrega2' => $material->entrega2
                ];

                $cambiosAplicados++;
            }

            // 🧱 Actualizar órdenes relacionadas
            foreach ($orderMap as $orderId => $materialIds) {
                $order = MixOrder::find($orderId);
                if (!$order) continue;

                // 🟢 Separar texto manual de bitácora automática
                $textoCompleto = trim($order->observaciones ?? '');
                $textoManual = '';
                $bitacoraExistente = [];
                
                if (!empty($textoCompleto)) {
                    // Si existe el separador, dividir
                    if (str_contains($textoCompleto, '|')) {
                        $partes = explode('|', $textoCompleto, 2);
                        $textoManual = trim($partes[0]);
                        $textoAutomatico = trim($partes[1]);
                        
                        // Parsear la bitácora automática existente
                        foreach (explode("\n", $textoAutomatico) as $linea) {
                            $partes = explode(": ", $linea, 2);
                            if (count($partes) === 2) {
                                $bitacoraExistente[$partes[0]] = $partes[1];
                            }
                        }
                    } else {
                        // No hay separador, considerar todo como texto manual
                        $textoManual = $textoCompleto;
                    }
                }

                // 🔁 Generar nueva bitácora por materiales modificados
                foreach ($materialIds as $materialId) {
                    $material = Material::find($materialId);
                    if (!$material) continue;

                    $code = $material->code;
                    $historial = json_decode($material->lot_changes_history ?? '[]', true);
                    if (empty($historial)) continue;

                    $ultimo = end($historial);
                    $nueva = "{$ultimo['antiguo_valor']} / {$ultimo['usuario']} / " .
                            \Carbon\Carbon::parse($ultimo['fecha'])->format('d-m-Y');

                    $observacionActual = $bitacoraExistente[$code] ?? '';
                    if (!str_contains($observacionActual, $nueva)) {
                        if ($observacionActual) {
                            $bitacoraExistente[$code] .= ", $nueva";
                        } else {
                            $bitacoraExistente[$code] = $nueva;
                        }
                    }
                }

                // 🧾 Construir bitácora unificada
                $nuevaBitacora = collect($bitacoraExistente)
                    ->map(fn($v, $k) => "$k: $v")
                    ->implode("\n");

                // 🟢 Construir observaciones finales: texto manual | bitácora
                if (!empty($textoManual) && !empty($nuevaBitacora)) {
                    $order->observaciones = $textoManual . " | Bitácora " . $nuevaBitacora;
                } elseif (!empty($textoManual)) {
                    $order->observaciones = $textoManual;
                } else {
                    $order->observaciones = $nuevaBitacora;
                }

                $order->status = 2;
                $order->lot1_changes = ($order->lot1_changes ?? 0) + 1;
                $order->strict_modification = true;
                $order->save();
            }

            DB::commit();

            $salida["code"] = 1;
            $salida["msg"]  = "Cambios aplicados correctamente: {$cambiosAplicados}";
            $salida["data"] = [
                "materials" => $materialesActualizados,
                "observaciones" => $order->observaciones ?? null
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            \Log::error("Error en cambio de lotes: " . $ex->getMessage() . "\n" . $ex->getTraceAsString());
            $salida["msg"] = "Error: " . $ex->getMessage();
        }

        return $salida;
    }

    // Dentro de MixController (por ejemplo al final de la clase)
    // Dentro de MixController
   private function mergeObservations(?string $existing, ?string $newText): string
    {
        $existing = $existing ?? '';
        $newText  = trim((string) $newText);

        // Si no viene nada nuevo, devolvemos lo que ya está
        if ($newText === '') {
            return $existing;
        }

        $manual   = '';
        $bitacora = '';

        // 1) Separar parte manual de bitácora automática (si existe el separador "|")
        if (str_contains($existing, '|')) {
            [$manual, $bitacora] = array_map('trim', explode('|', $existing, 2));
        } else {
            $manual = trim($existing);
        }

        // 2) Descomponer comentarios ya guardados
        $lineasExistentesStr  = [];
        $observacionesExistentes = []; // solo el texto después de "):"

        if ($manual !== '') {
            $lineasExistentesStr = preg_split('/\r\n|\r|\n/', $manual);

            foreach ($lineasExistentesStr as $linea) {
                $linea = trim($linea);
                if ($linea === '') continue;

                if (preg_match('/\):\s*(.+)$/', $linea, $m2)) {
                    $observacionesExistentes[] = trim($m2[1]);
                } else {
                    $observacionesExistentes[] = $linea;
                }
            }
        }

        // 3) Analizar lo que viene del textarea
        $lineasNew   = preg_split('/\r\n|\r|\n/', $newText);
        $ultimaLinea = trim(end($lineasNew) ?: '');

        if ($ultimaLinea === '') {
            // No hay nada útil → devolvemos como estaba
            return $existing;
        }

        // Si viene con formato "Usuario (fecha): texto", quedarnos solo con "texto"
        if (preg_match('/\):\s*(.+)$/', $ultimaLinea, $m)) {
            $textoNuevo = trim($m[1]);
        } else {
            $textoNuevo = $ultimaLinea;
        }

        $usuario = session('user_cur_fullname') ?? (Auth::user()->name ?? 'N/D');
        $fecha   = now('America/El_Salvador')->format('Y-m-d H:i:s');

        /**
         * 🔁 CASO 1: el textarea SOLO tiene una línea
         * ⇒ asumimos que el usuario está EDITANDO la última observación
         */
        if (count($lineasNew) === 1 && count($lineasExistentesStr) >= 1) {

            $ultimoTextoGuardado = end($observacionesExistentes) ?: '';

            // Si el texto es exactamente igual al último, no cambiamos nada
            if ($textoNuevo === $ultimoTextoGuardado) {
                if ($manual !== '' && $bitacora !== '') {
                    return $manual . ' | ' . $bitacora;
                } elseif ($manual !== '') {
                    return $manual;
                }
                return $bitacora;
            }

            // Reemplazar SOLO la última línea
            $nuevaLinea = "{$usuario} ({$fecha}): {$textoNuevo}";
            $lineasExistentesStr[count($lineasExistentesStr) - 1] = $nuevaLinea;

            $manual = implode("\n", $lineasExistentesStr);

            // Volvemos a unir manual | bitácora
            if ($manual !== '' && $bitacora !== '') {
                return $manual . ' | ' . $bitacora;
            } elseif ($manual !== '') {
                return $manual;
            }
            return $bitacora;
        }

        /**
         * ➕ CASO 2: hay varias líneas nuevas
         * ⇒ tratamos como comentarios adicionales (comportamiento anterior)
         */

        // Si el texto nuevo ya existe exactamente, no lo duplicamos
        if (in_array($textoNuevo, $observacionesExistentes, true)) {
            if ($manual !== '' && $bitacora !== '') {
                return $manual . ' | ' . $bitacora;
            } elseif ($manual !== '') {
                return $manual;
            }
            return $bitacora;
        }

        $nuevaLinea = "{$usuario} ({$fecha}): {$textoNuevo}";

        if ($manual !== '') {
            $manual .= "\n" . $nuevaLinea;
        } else {
            $manual = $nuevaLinea;
        }

        if ($manual !== '' && $bitacora !== '') {
            return $manual . ' | ' . $bitacora;
        } elseif ($manual !== '') {
            return $manual;
        }
        return $bitacora;
    }




   
    
}
