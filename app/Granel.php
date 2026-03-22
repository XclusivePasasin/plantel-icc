<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\MixOrder;
use App\ControlProducto;

class Granel extends Model
{
    protected $table="granel";
    protected $casts = [
        'parametros' => 'array', // Laravel manejará JSON ↔ array automáticamente
    ];
    // Function que verifica si existe un analisis de agua para una orden de produccion

  private function cleanValue($value)
    {
        if ($value === null) return null;

        // Convertir siempre a UTF-8 válido
        $clean = mb_convert_encoding($value, 'UTF-8', 'UTF-8');

        // Eliminar caracteres de control y nulos
        $clean = preg_replace('/[\x00-\x1F\x7F]/u', '', $clean);

        return trim($clean);
    }

    // public function search($order_code, $obj)
    // {
    //     $salida = [
    //         "code" => 0,
    //         "msg"  => "",
    //         "data" => null
    //     ];

    //     $user    = $obj->nombre;
    //     $usuario = ['username' => $obj->nombre, 'rolname' => $obj->rolabv];

    //     // 🔹 Normalizar código (10191 - 20 → 10191-20)
    //     $order_code_normalized = str_replace(' ', '', $order_code);

    //     $order = MixOrder::where('num_id', $order_code_normalized)->first();
    //     if (!$order) {
    //         $salida["msg"] = "Orden no encontrada en BD";
    //         return $salida;
    //     }

    //     $granel = Granel::where('mix_order_id', $order->id)->first();

    //     if ($granel) {
    //         // ⚠️ NO sobrescribimos fechas en el modelo
    //         $parametros = $granel->parametros ?? [];
    //         $necesitaActualizar = false;

    //         foreach ($parametros as $p) {
    //             if (
    //                 empty($p["values"]["temp"]) ||
    //                 empty($p["values"]["especification"])
    //             ) {
    //                 $necesitaActualizar = true;
    //                 break;
    //             }
    //         }

    //         if ($necesitaActualizar) {
    //             \Log::info("🔍 Necesita actualizar parametros para orden: {$order_code}");

    //             // 🔹 Pasar a SAP en formato con espacio (si SAP lo requiere)
    //             $sapOrderCode = str_replace('-', ' - ', $order_code_normalized);
    //             $sapParams = $this->getParamsFromSAP($sapOrderCode);

    //             \Log::info("📡 Respuesta SAP: " . json_encode($sapParams, JSON_UNESCAPED_UNICODE));

    //             if ($sapParams) {
    //                 foreach ($parametros as &$param) {
    //                     switch (strtoupper($param["id"])) {
    //                         case "VISCOCIDAD":
    //                         case "VISCOSIDAD":
    //                             $param["values"]["temp"]           = $sapParams["temperatura_viscosidad"];
    //                             $param["values"]["especification"] = $sapParams["especificaciones_viscosidad"];
    //                             break;
    //                         case "PH":
    //                             $param["values"]["temp"]           = $sapParams["temperatura_ph"];
    //                             $param["values"]["especification"] = $sapParams["especificaciones_ph"];
    //                             break;
    //                         case "DENSIDAD":
    //                             $param["values"]["temp"]           = $sapParams["temperatura_densidad"];
    //                             $param["values"]["especification"] = $sapParams["especificaciones_densidad"];
    //                             break;
    //                     }
    //                 }
    //                 unset($param);

    //                 // Guardar solo parámetros
    //                 $granel->parametros = $parametros;
    //                 $granel->save();
    //             } else {
    //                 \Log::warning("⚠️ No se encontraron parametros en SAP para orden {$sapOrderCode}");
    //             }
    //         }

    //         // ✅ Preparar respuesta con fechas formateadas (NO se guarda en BD)
    //         $granelResponse = clone $granel;
    //         $granelResponse->fecha_fabricacion = $granel->fecha_fabricacion
    //             ? date("d/m/Y", strtotime($granel->fecha_fabricacion))
    //             : null;
    //         $granelResponse->fecha_expiracion  = $granel->fecha_expiracion
    //             ? date("d/m/Y", strtotime($granel->fecha_expiracion))
    //             : null;

    //         $salida["code"]           = 1;
    //         $salida["msg"]            = "Processed Successfully";
    //         $salida["data"]["order"]  = $order;
    //         $salida["data"]["granel"] = $granelResponse;
    //         $salida["data"]["user"]   = $usuario;

    //     } else {
    //         $granel = $this->getNewObject($order);
    //         if ($usuario['rolname'] == 'MEZCLA') {
    //             $granel->responsables = $user;
    //         }
    //         $salida["code"]           = 2;
    //         $salida["msg"]            = "No existe granel para esa orden";
    //         $salida["data"]["order"]  = $order;
    //         $salida["data"]["granel"] = $granel;
    //         $salida["data"]["user"]   = $usuario;
    //     }

    //     return $salida;
    // }

    public function search($order_code, $obj)
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        $user    = $obj->nombre;
        $usuario = ['username' => $obj->nombre, 'rolname' => $obj->rolabv];

        $order_code_normalized = str_replace(' ', '', $order_code);

        $order = MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$order_code_normalized])->first();
        if (!$order) {
            $salida["msg"] = "Orden no encontrada en BD";
            return $salida;
        }

        $granel = Granel::where('mix_order_id', $order->id)->first();

        if ($granel) {
            $parametros = $granel->parametros ?? [];

            // 🔹 Buscar siempre en ControlProducto
            $control = ControlProducto::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$order_code_normalized])->first();

            // 🔹 Buscar siempre en SAP
            $sapOrderCode = str_replace('-', ' - ', $order_code_normalized);
            $sapParams = $this->getParamsFromSAP($sapOrderCode);

            foreach ($parametros as &$param) {
                switch (strtoupper($param["id"])) {
                    case "VISCOCIDAD":
                    case "VISCOSIDAD":
                        if ($sapParams) {
                            $param["values"]["temp"]           = $sapParams["temperatura_viscosidad"];
                            $param["values"]["especification"] = $sapParams["especificaciones_viscosidad"];
                        }
                        if ($control) {
                            $param["values"]["results"]   = $this->cleanValue($control->viscosidad_producto ?? "");
                            $param["values"]["create_by"] = $this->cleanValue($control->usuario_crea ?? "");
                        }
                        break;

                    case "PH":
                        if ($sapParams) {
                            $param["values"]["temp"]           = $sapParams["temperatura_ph"];
                            $param["values"]["especification"] = $sapParams["especificaciones_ph"];
                        }
                        if ($control) {
                            $param["values"]["results"]   = $this->cleanValue($control->ph_producto ?? "");
                            $param["values"]["create_by"] = $this->cleanValue($control->usuario_crea ?? "");
                        }
                        break;

                    case "DENSIDAD":
                        if ($sapParams) {
                            $param["values"]["temp"]           = $sapParams["temperatura_densidad"];
                            $param["values"]["especification"] = $sapParams["especificaciones_densidad"];
                        }
                        if ($control) {
                            $param["values"]["results"]   = $this->cleanValue($control->densidad_producto ?? "");
                            $param["values"]["create_by"] = $this->cleanValue($control->usuario_crea ?? "");
                        }
                        break;
                }
            }
            unset($param);

            $granel->parametros = $parametros;
            $granel->save();

            // ✅ Preparar respuesta
            $granelResponse = clone $granel;
            $granelResponse->fecha_fabricacion = $granel->fecha_fabricacion
                ? date("d/m/Y", strtotime($granel->fecha_fabricacion))
                : null;
            $granelResponse->fecha_expiracion  = $granel->fecha_expiracion
                ? date("d/m/Y", strtotime($granel->fecha_expiracion))
                : null;

            $salida["code"]           = 1;
            $salida["msg"]            = "Processed Successfully";
            $salida["data"]["order"]  = $order;
            $salida["data"]["granel"] = $granelResponse;
            $salida["data"]["user"]   = $usuario;

        } else {
            $granel = $this->getNewObject($order);
            if ($usuario['rolname'] == 'MEZCLA') {
                $granel->responsables = $user;
            }
            $salida["code"]           = 2;
            $salida["msg"]            = "No existe granel para esa orden";
            $salida["data"]["order"]  = $order;
            $salida["data"]["granel"] = $granel;
            $salida["data"]["user"]   = $usuario;
        }

        return $salida;
    }

    /**
     * Función auxiliar para consultar SAP y devolver parámetros
     */
    private function getParamsFromSAP($order_code)
    {
        try {
            $url      = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                \Log::error("❌ Error al conectar con SAP: " . $response->status());
                return null;
            }

            $raw = $response->body();

            // 🔧 Limpiar BOM y caracteres invisibles
            $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $raw);             // BOM
            $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);    // caracteres invisibles

            \Log::info("RAW SAP Response (limpio1): " . substr($cleanBody, 0, 200));

            $items = json_decode($cleanBody, true);

            // Si falla la decodificación, intentar limpieza más agresiva
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error('Error al decodificar JSON: ' . json_last_error_msg());
                \Log::error('Cuerpo después de limpiar (intento1): ' . substr($cleanBody, 0, 200));

                // Segunda pasada: eliminar TODO lo no imprimible
                $cleanBody = preg_replace('/[^[:print:]]/', '', $cleanBody);
                $items = json_decode($cleanBody, true);

                \Log::info("RAW SAP Response (limpio2): " . substr($cleanBody, 0, 200));
            }

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error('Error persistente en decodificación: ' . json_last_error_msg());
                return null;
            }

            // Normalizar código local (10191-20 → 1019120)
            $localCode = preg_replace('/\s+/', '', $order_code);

            foreach ($items as $el) {
                $apiCode = preg_replace('/\s+/', '', $el["num"] ?? "");
                \Log::info("🔎 Comparando API={$apiCode} vs LOCAL={$localCode}");

                if ($apiCode === $localCode) {
                    \Log::info("✅ Coincidencia encontrada en SAP para {$order_code}");

                    return [
                        "temperatura_viscosidad"      => $this->cleanValue($el["temperatura_viscosidad"] ?? ""),
                        "temperatura_ph"              => $this->cleanValue($el["temperatura_ph"] ?? ""),
                        "temperatura_densidad"        => $this->cleanValue($el["temperatura_densidad"] ?? ""),
                        "especificaciones_viscosidad" => $this->cleanValue($el["especificaciones_viscosidad"] ?? ""),
                        "especificaciones_ph"         => $this->cleanValue($el["especificaciones_ph"] ?? ""),
                        "especificaciones_densidad"   => $this->cleanValue($el["especificaciones_densidad"] ?? "")
                    ];
                }
            }

            \Log::warning("⚠️ No se encontró la orden {$order_code} en SAP (LOCAL={$localCode})");
            return null;

        } catch (\Exception $e) {
            \Log::error("❌ Error consultando SAP: " . $e->getMessage());
            return null;
        }
    }


    

    // public function saveOrUpdate($request, $obj){
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];
    //     $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
    //     $request['user'] = $usuario;
    //     $user=$obj->nombre;
    //     DB::beginTransaction();
    //     try{

    //         $granel = null;
    //         if($request['order']->id != 0){
    //             $granel= Granel::where('mix_order_id',$request['order']->id)->first();
    //         }
            
    //         $granel= $this->getUpdateObject($granel, $request['granel'], $request['order']);
    //         if ($usuario['rolname'] == 'MEZCLA'){
    //             $granel->responsables = $user;
    //         }
    //         $granel->save();
    //         $granel->refresh();
    //         DB::commit();
    //         $granel->fecha_fabricacion= date("d/m/Y", strtotime($granel->fecha_fabricacion));
    //         $granel->fecha_expiracion= date("d/m/Y", strtotime($granel->fecha_expiracion));
    //         $request['granel']=$granel;
    //         $salida["code"] = 1;
    //         $salida["msg"] = "Processed Successfully";
    //         $salida["data"] = array($request);  
    //     }catch(\Exception $ex){
    //         DB::rollback();
    //         //$salida["msg"] = "Error en la operación, consulte soporte técnico.";
    //         $salida['msg'] = "Error: " . $ex->getMessage()." en linea ".$ex->getLine(); //for debugin   
    //         $salida["data"] = array($request);              
    //     }

    //     return $salida;
    // }
    public function saveOrUpdate($request, $obj)
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        $usuario = [
            'username' => $obj->nombre,
            'rolname'  => $obj->rolabv
        ];
        $request['user'] = $usuario;
        $user = $obj->nombre;

        DB::beginTransaction();
        try {
            $granel = null;
            if ($request['order']->id != 0) {
                $granel = Granel::where('mix_order_id', $request['order']->id)->first();
            }

            // Actualizar/crear granel
            $granel = $this->getUpdateObject($granel, $request['granel'], $request['order']);
            if ($usuario['rolname'] == 'MEZCLA') {
                $granel->responsables = $user;
            }

            $granel->save();
            $granel->refresh();

            DB::commit();

            // Formatear fechas SOLO para la respuesta
            $granel->fecha_fabricacion = date("d/m/Y", strtotime($granel->fecha_fabricacion));
            $granel->fecha_expiracion  = date("d/m/Y", strtotime($granel->fecha_expiracion));

            $request['granel'] = $granel;

            $salida["code"] = 1;
            $salida["msg"]  = "Processed Successfully";
            $salida["data"] = $request;   // ✅ Ahora es objeto plano, no array

        } catch (\Exception $ex) {
            DB::rollback();
            $salida["msg"]  = "Error: " . $ex->getMessage() . " en linea " . $ex->getLine();
            $salida["data"] = $request;   // también corregido aquí
        }

        return $salida;
    }

    

    public function getNewObject($order){
        $granel= new Granel();
        $granel->producto=$order->product_name;
        $granel->lote=$order->lot_num;
        $granel->batch="";
        $granel->status=1;
        $granel->tanque="";
        $granel->orden=$order->num_id;
        $granel->fecha_fabricacion= date("d/m/Y", strtotime($order->datetime_init));
        $granel->fecha_expiracion="";
        $granel->cantidad=1;
        $granel->proceso="Fabricación";
        $granel->cv1="";
        $granel->cv2="";
        
        /*$granel->viscosidad="";
        $granel->ph="";
        $granel->temperatura="";
        $granel->alcohol="";
        $granel->densidad="";*/

        $granel->parametros = $this->getTableParameters();
        $granel->responsables="";
        $granel->equipo="";
        $granel->user_crea="";
        $granel->user_upd="";
        $granel->mix_order_id=$order->id;
        return $granel;
    }

    public function getTableParameters(){
        return [
            ["id" => "VISCOSIDAD", "order" => 1, "values" => [
                "temp" => null,
                "especification" => null,
                "results" => null,
                "create_by" => null,
            ]],
            ["id" => "PH", "order" => 2, "values" => [
                "temp" => null,
                "especification" => null,
                "results" => null,
                "create_by" => null,
            ]],
            ["id" => "DENSIDAD", "order" => 3, "values" => [
                "temp" => null,
                "especification" => null,
                "results" => null,
                "create_by" => null,
            ]],                        
        ];
    }

    
    public function getUpdateObject($granel, $request, $order){
        if(is_null($granel))
            $granel= new Granel();
        
            $granel->producto=$request->producto;
            $granel->lote=$request->lote;
            $granel->batch=$request->batch;
            $granel->status=$request->status;
            $granel->tanque=$request->tanque;
            $granel->orden=$request->orden;
            //$granel->fecha_fabricacion=$request->fecha_fabricacion;
            //$granel->fecha_expiracion=$request->fecha_expiracion;
           $granel->fecha_fabricacion = \DateTime::createFromFormat('d/m/Y', $request->fecha_fabricacion)
                ? \DateTime::createFromFormat('d/m/Y', $request->fecha_fabricacion)->format('Y-m-d')
                : null;

            $granel->fecha_expiracion = \DateTime::createFromFormat('d/m/Y', $request->fecha_expiracion)
                ? \DateTime::createFromFormat('d/m/Y', $request->fecha_expiracion)->format('Y-m-d')
                : null;

            $granel->cantidad=$request->cantidad;
            $granel->proceso="Fabricación";
            $granel->parametros = $request->parametros; // ya es array, no json_encode
            // $granel->parametros = json_encode($request->parametros);
            $granel->cv1=$request->cv1;;
            $granel->cv2=$request->cv2;
            
            /*$granel->viscosidad=$request->viscosidad;
            $granel->ph=$request->ph;
            $granel->temperatura=$request->temperatura;
            $granel->alcohol=$request->alcohol;
            $granel->densidad=$request->densidad;*/

            $granel->responsables=$request->responsables;
            $granel->equipo=$request->equipo;
            $granel->user_crea="";
            $granel->user_upd="";
            $granel->mix_order_id=$order->id;
        return $granel;
    }
    
}
