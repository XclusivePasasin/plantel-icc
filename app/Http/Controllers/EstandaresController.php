<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Estandares;
use App\Packing;

class EstandaresController extends Controller
{
    //

    /*
    public function search(Request $request, $order_code){
        //$validar = $this->vaidarPermisos($request);
        $estandares = new Estandares();
        return $estandares->search($order_code);
        //return ($validar->code==1)?$granel->search($order_code):json_encode($validar);
    }

    */

    public function search(Request $request, $order_code, $turno){
        $estandares = new Estandares();
        $usuario= $this->obtenerUsuario($request);
        $validar = $this->vaidarPermisos($request);
        return ($validar->code==1)?$estandares->search($order_code, $turno, $usuario):json_encode($validar);
        //return $analisis->search($order_code, $request->session->get('user_cur_fullname'));
    }


    public function saveOrUpdate(Request $request){
        $validar = $this->vaidarPermisos($request);
        $estandares = new Estandares();
        $usuario= $this->obtenerUsuario($request);
        $datos['order']=json_decode(json_encode($request->order),FALSE);
        $datos['estandares']=json_decode(json_encode($request->estandares),FALSE);
        return ($validar->code==1)?$estandares->saveOrUpdate($datos, $usuario):json_encode($validar);
    }


    public function nextSection(Request $request)
    {
        $obj = auth()->user(); // o como obtengas el usuario autenticado
        $estandares = new Estandares();
        $result = $estandares->nextSection($request->all(), $obj);
        return response()->json($result);
    }
    /**
     * Obtiene el Json Modelo para componente un nuevo componente de estandares
     * para una cod orden enviada
     */

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

        $estandarInstance = new Estandares();
        $validar = $this->vaidarPermisos($request);

        $obj = $this->obtenerUsuario($request);
        $usuario = [
            'username' => $obj->nombre,
            'rolname' => $obj->rolabv
        ];

        // 👉 Limpiar y normalizar el código de orden
        $normalizedCode = preg_replace('/\s*-\s*/', '-', trim($orderCode));

        // Buscar orden de empaque
        $packingOrder = Packing::where('num_id', $normalizedCode)->first();
        if (!$packingOrder) {
            $salida["msg"] = "No se encontró la hoja de empaque principal";
            return $salida;
        }

        // 👉 Obtener presentación desde SAP (si aplica)
        $presentacion = $this->obtenerPresentacionDesdeSAP($normalizedCode);

        // 👉 Obtener estandares de calidad
        $estandares = $estandarInstance->getNewObject($packingOrder, $usuario, $turno);

        // 👉 Convertir orden a array para poder modificarlo
        $orderData = $packingOrder->toArray();
        $orderData['presentacion_sap'] = (!empty($presentacion) && is_string($presentacion)) ? $presentacion : 'No disponible';

        $salida["code"] = 2;
        $salida["msg"] = "No existe estandares para esa orden";
        $salida["data"]["order"] = $orderData;
        $salida["data"]["estandares"] = $estandares;
        $salida["data"]["user"] = $usuario;

        return ($validar->code == 1) ? $salida : $validar;
    }

    // public function model(Request $request, $orderCode, $turno){
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => []
    //     ];

    //     $estandarInstance = new Estandares();
    //     $validar = $this->vaidarPermisos($request);

    //     $obj= $this->obtenerUsuario($request);
    //     $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);

    //     $packingOrder = Packing::where('num_id',$orderCode)->first();
    //     if(!$packingOrder){
    //         $salida["msg"] = "No se encontro la hoja de empaque principal";
    //         return $salida;
    //     }
    //     /*Realizar validaciones que se requieren, por ejemplo maximo de hojas de estandares */

    //     $estandares= $estandarInstance->getNewObject($packingOrder, $usuario, $turno);
    //     $salida["code"] = 2;
    //     $salida["msg"] = "No existe estandares para esa orden";
    //     $salida["data"]["order"] = $packingOrder;
    //     $salida["data"]["estandares"] = $estandares;
    //     $salida["data"]["user"] = $usuario;
    //     return ($validar->code==1)?$salida:$validar;
    // }

    public function findById(Request $request, $id){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => []
        ];

        $estandarInstance = new Estandares();
        $obj= $this->obtenerUsuario($request);
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        $permisos = $this->vaidarPermisos($request);

        $estandar = Estandares::find($id);
        if(!$estandar){
            $salida["msg"] = "No se encontro la hoja de estandar";
            return $salida;
        }
        $estandar = $estandarInstance->getParseObject($estandar);


        $order = Packing::find($estandar->packing_id);
        if(!$order){
            $salida["code"] = 0;
            $salida["msg"] = "No existe estandares para esa orden";
            return $salida;
        }

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"]["order"] = $order;
        $salida["data"]["estandares"] = $estandar;
        $salida["data"]["user"] = $usuario;

        return ($permisos->code==1)?$salida:$permisos;
    }

    public function allByPackingCode(Request $request, $orderCode, $turno){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $packing = Packing::where('num_id', $orderCode)->first();
        if(!$packing){
            $salida["msg"] = "Numero de orden no existe";
            return $salida;
        }


        $permisos = $this->vaidarPermisos($request);
        $estandares = Estandares::select('id', 'turno', 'created_at', 'updated_at', 'seccion')->where('packing_id', $packing->id)->where('turno', $turno)->orderBy('created_at')->get();
        //$estandares = Estandares::where('packing_id', $packing->id)->where('turno', $turno)->get();
        $salida["code"] = 1;
        $salida["data"] = $estandares;
        return ($permisos->code==1)?$salida:$permisos;
    }




    public function vaidarPermisos(Request $request){
        if (! $request->user()->hasRole("Produccion") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("AuxControlCalidad")) {
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
        if (!$request->user()->hasRole("Produccion") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("AuxControlCalidad")) {
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
                "cargo" => "PRODUCCION",
            ];
        }
        else if($request->user()->hasRole("SupProduccion")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "SupProduccion",
                "rolabv" => "SPROD",
                "cargo" => "SUPERVISOR PRODUCCION",
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
        $respuesta= json_decode(json_encode($salida),FALSE);
        return $respuesta;
    }



}
