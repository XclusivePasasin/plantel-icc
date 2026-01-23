<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Granel;
use App\ControlProducto;

class GranelController extends Controller
{
    public function search(Request $request, $order_code)
    {
        $validar = $this->vaidarPermisos($request);
        $granel  = new Granel();
        $usuario = $this->obtenerUsuario($request);

        // 🔹 Eliminar espacios internos y externos
        $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);

        return ($validar->code == 1)
            ? $granel->search($normalizedOrderCode, $usuario)
            : json_encode($validar);
    }


    private function cleanValue($value)
    {
        if ($value === null) return null;

        // Convertir siempre a UTF-8 válido
        $clean = mb_convert_encoding($value, 'UTF-8', 'UTF-8');

        // Eliminar caracteres de control y nulos
        $clean = preg_replace('/[\x00-\x1F\x7F]/u', '', $clean);

        return trim($clean);
    }

    public function searchOrderSpecs($order_code)
    {
        $salida = [
            "code" => 0,
            "msg"  => "",
            "data" => null
        ];

        try {
            $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);
            \Log::info("Normalized Order Code: " . $normalizedOrderCode);

            // 🔹 1. Buscar primero en tabla local ControlProducto
            $control = ControlProducto::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalizedOrderCode])->first();

            if ($control) {
                $salida["code"] = 1;
                $salida["msg"]  = "Found in ControlProducto";
                $salida["data"] = [
                    "ph"        => $this->cleanValue($control->ph_producto ?? ""),
                    "viscosidad"=> $this->cleanValue($control->viscosidad_producto ?? ""),
                    "densidad"  => $this->cleanValue($control->densidad_producto ?? ""),
                    "firma"     => $this->cleanValue($control->usuario_crea ?? ""),
                ];
                \Log::info("Found in DB ControlProducto: " . json_encode($salida["data"]));
                return $salida;
            }

            // 🔹 2. Si no existe en tabla local → buscar en API externa
            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                $salida["msg"] = "Failed to connect to API";
                \Log::error("API Connection Failed: " . $response->status());
                return $salida;
            }

            $items = json_decode($response->body(), true);
            \Log::info("API Response: " . json_encode($items, JSON_PRETTY_PRINT));

            if (!is_array($items)) {
                $salida["msg"] = "Failed to decode API response";
                \Log::error("Invalid API Response: Not an array");
                return $salida;
            }

            foreach ($items as $el) {
                $e = (object) $el;
                $normalizedApiNum = preg_replace('/\s+/', '', $e->num ?? '');
                if ($normalizedApiNum === $normalizedOrderCode) {
                    $salida["code"] = 1;
                    $salida["msg"]  = "Processed Successfully (from API)";
                    $salida["data"] = [
                        "temperatura_viscosidad"      => $this->cleanValue($e->temperatura_viscosidad ?? ""),
                        "temperatura_ph"              => $this->cleanValue($e->temperatura_ph ?? ""),
                        "temperatura_densidad"        => $this->cleanValue($e->temperatura_densidad ?? ""),
                        "especificaciones_viscosidad" => $this->cleanValue($e->especificaciones_viscosidad ?? ""),
                        "especificaciones_ph"         => $this->cleanValue($e->especificaciones_ph ?? ""),
                        "especificaciones_densidad"   => $this->cleanValue($e->especificaciones_densidad ?? ""),
                    ];
                    \Log::info("Found Match in API: " . json_encode($salida["data"]));
                    return $salida;
                }
            }

            $salida["msg"] = "Order not found in API or DB";
            \Log::warning("No matching order found for code: " . $normalizedOrderCode);
            return $salida;

        } catch (\Exception $e) {
            \Log::error("Exception in searchOrderSpecs: " . $e->getMessage());
            $salida["msg"] = "Unexpected error in process";
            return $salida;
        }
    }

    // public function searchOrderSpecs($order_code)
    // {
    //     $salida = [
    //         "code" => 0,
    //         "msg"  => "",
    //         "data" => null
    //     ];

    //     try {
    //         $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);
    //         \Log::info("Normalized Order Code: " . $normalizedOrderCode);

    //         $url = "https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php";
    //         $response = Http::withoutVerifying()->get($url);

    //         if ($response->failed()) {
    //             $salida["msg"] = "Failed to connect to API";
    //             \Log::error("API Connection Failed: " . $response->status());
    //             return $salida;
    //         }

    //         $items = json_decode($response->body(), true);
    //         \Log::info("API Response: " . json_encode($items, JSON_PRETTY_PRINT));

    //         if (!is_array($items)) {
    //             $salida["msg"] = "Failed to decode API response";
    //             \Log::error("Invalid API Response: Not an array");
    //             return $salida;
    //         }

    //         foreach ($items as $el) {
    //             $e = (object) $el;
    //             $normalizedApiNum = preg_replace('/\s+/', '', $e->num ?? '');
    //             \Log::info("Comparing API num: '$normalizedApiNum' with Order Code: '$normalizedOrderCode'");
    //             if ($normalizedApiNum === $normalizedOrderCode) {
    //                 $salida["code"] = 1;
    //                 $salida["msg"]  = "Processed Successfully";
    //                 $salida["data"] = [
    //                     "temperatura_viscosidad"      => $this->cleanValue($e->temperatura_viscosidad ?? ""),
    //                     "temperatura_ph"              => $this->cleanValue($e->temperatura_ph ?? ""),
    //                     "temperatura_densidad"        => $this->cleanValue($e->temperatura_densidad ?? ""),
    //                     "especificaciones_viscosidad" => $this->cleanValue($e->especificaciones_viscosidad ?? ""),
    //                     "especificaciones_ph"         => $this->cleanValue($e->especificaciones_ph ?? ""),
    //                     "especificaciones_densidad"   => $this->cleanValue($e->especificaciones_densidad ?? ""),
    //                 ];
    //                 \Log::info("Found Match - Data: " . json_encode($salida["data"]));
    //                 return $salida;
    //             }
    //         }

    //         $salida["msg"] = "Order not found in API";
    //         \Log::warning("No matching order found for code: " . $normalizedOrderCode);
    //         return $salida;

    //     } catch (\Exception $e) {
    //         \Log::error("Exception in searchOrderSpecs: " . $e->getMessage());
    //         $salida["msg"] = "Unexpected error in process";
    //         return $salida;
    //     }
    // }


    public function saveOrUpdate(Request $request)
    {
        $validar = $this->vaidarPermisos($request);
        $granel  = new Granel();
        $usuario = $this->obtenerUsuario($request);

        $datos['order']  = json_decode(json_encode($request->order), FALSE);
        $datos['granel'] = json_decode(json_encode($request->granel), TRUE);

        // 🔹 Normalizar el código (quita todos los espacios)
        $orderCode = isset($datos['order']->num) 
            ? preg_replace('/\s+/', '', $datos['order']->num) 
            : null;

        if ($orderCode && isset($datos['granel']['parametros'])) {
            $specs = $this->searchOrderSpecs($orderCode);

            if ($specs['code'] == 1) {
                $parametros = is_string($datos['granel']['parametros'])
                    ? json_decode($datos['granel']['parametros'], true)
                    : (array) $datos['granel']['parametros'];

                foreach ($parametros as &$param) {
                    // Inicializamos siempre 'values' si no existe
                    if (!isset($param['values']) || !is_array($param['values'])) {
                        $param['values'] = [];
                    }

                    switch (strtoupper($param['id'])) {
                        case 'VISCOSIDAD':   // ✅ corregido
                        case 'VISCOCIDAD':   // 👈 soporte mientras tanto
                            $param['values']['temp'] = $specs['data']['temperatura_viscosidad'] ?? 'DEF_TEMP_VISCO';
                            $param['values']['especification'] = $specs['data']['especificaciones_viscosidad'] ?? 'DEF_SPEC_VISCO';
                            break;

                        case 'PH':
                            $param['values']['temp'] = $specs['data']['temperatura_ph'] ?? 'DEF_TEMP_PH';
                            $param['values']['especification'] = $specs['data']['especificaciones_ph'] ?? 'DEF_SPEC_PH';
                            break;

                        case 'DENSIDAD':
                            $param['values']['temp'] = $specs['data']['temperatura_densidad'] ?? 'DEF_TEMP_DENS';
                            $param['values']['especification'] = $specs['data']['especificaciones_densidad'] ?? 'DEF_SPEC_DENS';
                            break;

                        default:
                            \Log::warning("Parametro no reconocido: " . $param['id']);
                            break;
                    }

                }


                // 🔹 Guardar en la BD como string JSON
                $datos['granel']['parametros'] = json_encode($parametros, JSON_UNESCAPED_UNICODE);
            }
        }

        // Mantener compatibilidad con tu modelo (stdClass)
        $datos['granel'] = json_decode(json_encode($datos['granel']), FALSE);

        return ($validar->code == 1)
            ? $granel->saveOrUpdate($datos, $usuario)
            : json_encode($validar);
    }

        
    // public function saveOrUpdate(Request $request){
    //     $validar = $this->vaidarPermisos($request);
    //     $granel = new Granel();
    //     $usuario= $this->obtenerUsuario($request);
    //     $datos['order']=json_decode(json_encode($request->order),FALSE);
    //     $datos['granel']=json_decode(json_encode($request->granel),FALSE);
    //     return ($validar->code==1)?$granel->saveOrUpdate($datos, $usuario):json_encode($validar);        
    // }

    public function vaidarPermisos(Request $request){
        if (!$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("JefeControlCalidad") && !$request->user()->hasRole("AuxControlCalidad")) {
            $salida = [
                "code" => 0,
                "msg" => "No tienes permisos para ejecutar esta operacion",
                "data" => null
            ];
        }
        else{
            $salida = [
                "code" => 1,
                "msg" => "Usuario Autorizado",
                "data" => null
            ];
        }
        $respuesta= json_decode(json_encode($salida),FALSE);    
        return $respuesta; 
    }
    
    public function obtenerUsuario(Request $request){
        if (!$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("Calidad")) {
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
                "rolname" => "MEZCLA",
                "rolabv" => "MEZCLA",
                "cargo" => "Encargado de Mezcla",
            ];
        }
        else if($request->user()->hasRole("Calidad")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "CALIDAD",
                "rolabv" => "CALIDAD",
                "cargo" => "Encargado de Calidad",
            ];
        }
        $respuesta= json_decode(json_encode($salida),FALSE);    
        return $respuesta; 
    }

}
