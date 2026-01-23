<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Controles;
use App\Packing;


class ControlesController extends Controller
{
    public function search(Request $request, $order_code, $turno)
    {
        $controles = new Controles();
        $usuario = $this->obtenerUsuario($request);
        $validar = $this->validarPermisos($request);

        return ($validar->code==1)?$controles->search($order_code, $turno, $usuario):json_encode($validar);
    }

    public function saveOrUpdate(Request $request)
    {
        $validar = $this->validarPermisos($request);
        $controles = new Controles();
        $usuario = $this->obtenerUsuario($request);

        $datos['order'] = json_decode(json_encode($request->order), false);
        $datos['controles'] = json_decode(json_encode($request->controles), false);
        $datos['accion'] = $request->accion;

        if ($validar->code != 1) {
            return response()->json($validar);
        }

        // ✅ Si ya existe un control hoy para esta orden y turno, forzamos actualización
        if (!empty($datos['order']->id)) {
            $existe = \App\Controles::where('packing_id', $datos['order']->id)
                ->where('turno', $datos['controles']->turno)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if ($existe) {
                $datos['accion'] = 'editar'; // 👈 forzamos actualización automática
            }
        }

        return response()->json($controles->saveOrUpdate($datos, $usuario));
    }



    // public function saveOrUpdate(Request $request)
    // {
    //     $validar = $this->validarPermisos($request);
    //     $controles = new Controles();
    //     $usuario = $this->obtenerUsuario($request);

    //     $datos['order'] = json_decode(json_encode($request->order), false);
    //     $datos['controles'] = json_decode(json_encode($request->controles), false);
    //     $datos['accion'] = $request->accion;

    //     if ($validar->code == 1) {
    //         return response()->json($controles->saveOrUpdate($datos, $usuario));
    //     } else {
    //         return response()->json($validar);
    //     }
    // }

    public function obtenerPresentacionDesdeSAP($productCode)
    {
        // $url = "https://192.168.6.26/wsPlantel/empaque.php";
        $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";

        try {
            $response = Http::withoutVerifying()->timeout(20)->get($url);

            if ($response->failed()) {
                \Log::error("Error en la API SAP. Estado: " . $response->status());
                return 21; // Valor por defecto
            }

            $body = $response->body();

            // Limpieza del cuerpo (por si contiene BOM u otros caracteres)
            $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
            $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);

            $items = json_decode($cleanBody, true);

            // Segundo intento si falla la decodificación
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::warning("Error al decodificar JSON. Intentando limpieza adicional...");
                $cleanBody = preg_replace('/[^[:print:]]/', '', $cleanBody);
                $items = json_decode($cleanBody, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                    \Log::error('Error persistente en decodificación: ' . json_last_error_msg());
                    return 21; // Valor por defecto
                }
            }

            // Normalización del código buscado
            $codigoBuscado = preg_replace('/\s+/', '', $productCode);
            \Log::info("Código buscado normalizado: {$codigoBuscado}");

            foreach ($items as $item) {
                if (!isset($item['num'])) {
                    continue;
                }

                $codigoItem = preg_replace('/\s+/', '', $item['num']);

                if ($codigoItem === $codigoBuscado) {
                    $presentacion = $item['presentacion'] ?? null;
                    \Log::info("Presentación encontrada: {$presentacion}");
                    return $presentacion;
                }
            }

            \Log::warning("Código no encontrado: {$codigoBuscado}");
        } catch (\Exception $e) {
            \Log::error("Excepción al consultar SAP: " . $e->getMessage());
        }

        return null; // Valor por defecto si no se encuentra
    }


    public function model(Request $request, $orderCode, $turno)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => []
        ];

        $controlInstance = new Controles();
        $validar = $this->validarPermisos($request);

        $obj = $this->obtenerUsuario($request);
        $usuario = [
            'username' => $obj->nombre,
            'rolname' => $obj->rolabv
        ];

        $packingOrder = Packing::where('num_id', $orderCode)->first();
        if (!$packingOrder) {
            $salida["msg"] = "No se encontró la hoja de empaque principal";
            return $salida;
        }

        // 👉 Normalizar num_id al formato "XXXX - XX" antes de pasarlo
        $normalizedNumId = preg_replace('/\s*-\s*/', '-', trim($packingOrder->num_id));


        // 👉 Consultar presentación desde SAP usando el num_id normalizado
        $presentacion = $this->obtenerPresentacionDesdeSAP($normalizedNumId);

        // 👉 Convertir Eloquent a array y añadir presentación
        $orderData = $packingOrder->toArray();
        $orderData['presentacion_sap'] = (!empty($presentacion) && is_string($presentacion)) ? $presentacion : 'No disponible';


        $controles = $controlInstance->getNewObject($packingOrder, $usuario, $turno);

        $salida["code"] = 2;
        $salida["msg"] = "No existe controles para esa orden";
        $salida["data"]["order"] = $orderData;
        $salida["data"]["controles"] = $controles;
        $salida["data"]["user"] = $usuario;

        return ($validar->code == 1) ? $salida : $validar;
    }

    public function findById(Request $request, $id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => []
        ];

        try {
            $controlInstance = new Controles();
            $obj = $this->obtenerUsuario($request);
            $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
            $permisos = $this->validarPermisos($request);

            $control = Controles::find($id);
            if (!$control) {
                $salida["msg"] = "No se encontró la hoja de control";
                return $salida;
            }
            $control = $controlInstance->getParseObject($control);

            $order = Packing::find($control->packing_id);
            if (!$order) {
                $salida["code"] = 0;
                $salida["msg"] = "No existe controles para esa orden";
                return $salida;
            }

            $salida["code"] = 1;
            $salida["msg"] = "Processed Successfully";
            $salida["data"]["order"] = $order;
            $salida["data"]["controles"] = $control;
            $salida["data"]["user"] = $usuario;

            return ($permisos->code == 1) ? $salida : $permisos;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Se ejecuto pero resulto un error interno en el servidor'], 500);
        }
    }


    public function allByPackingCode(Request $request, $orderCode, $turno)
    {
        try {
            $salida = [
                "code" => 0,
                "msg" => "",
                "data" => null
            ];

            $packing = Packing::where('num_id', $orderCode)->first();
            if (!$packing) {
                $salida["msg"] = "Numero de orden no existe";
                return $salida;
            }

            $permisos = $this->validarPermisos($request);
            $controles = Controles::select('id', 'turno', 'created_at', 'updated_at', 'seccion')
                ->where('packing_id', $packing->id)
                ->where('turno', $turno)
                ->orderBy('created_at')
                ->get();

            $salida["code"] = 1;
            $salida["data"] = $controles;
            return ($permisos->code == 1) ? $salida : $permisos;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Se ejecuto pero resulto un error interno en el servidor'], 500);
        }
    }


    private function validarPermisos(Request $request)
    {
        if (!$request->user()->hasRole("Produccion") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("JefeProduccion")) {
            $salida = [
                "code" => 0,
                "msg" => "No tienes permisos para ejecutar esta operación",
                "data" => null
            ];
        } else {
            $salida = [
                "code" => 1,
                "msg" => "Usuario Autorizado",
                "data" => null
            ];
        }
        return json_decode(json_encode($salida), false);
    }

    private function obtenerUsuario(Request $request)
    {
        if (!$request->user()->hasRole("Produccion") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("JefeProduccion")) {
            $salida = [
                "email" => "",
                "nombre" => "",
                "rolname" => "",
                "rolabv" => "",
                "cargo" => "",
            ];
        } else if ($request->user()->hasRole("Calidad")) {
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "CALIDAD",
                "rolabv" => "CL",
                "cargo" => "ANALISTA DE CALIDAD",
            ];
        } else if ($request->user()->hasRole("Produccion")) {
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "Produccion",
                "rolabv" => "PROD",
                "cargo" => "PRODUCCION",
            ];
        } else if ($request->user()->hasRole("SupProduccion")) {
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "SupProduccion",
                "rolabv" => "SPROD",
                "cargo" => "SUPERVISOR PRODUCCION",
            ];
        } else if ($request->user()->hasRole("JefeProduccion")) {
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "JefeProduccion",
                "rolabv" => "JPROD",
                "cargo" => "JEFE DE PRODUCCION",
            ];
        }
        return json_decode(json_encode($salida), false);
    }
}
