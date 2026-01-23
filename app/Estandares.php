<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Packing;
use Illuminate\Support\Facades\Http;

class Estandares extends Model
{
    protected $table = "estandares";

    // Método para buscar estandares
    public function search($order_code, $turno, $obj)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $user = $obj->nombre;
        // Se crea un arreglo con la información del usuario
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        $order = Packing::where('num_id', $order_code)->first();

        if ($order) {
            // Obtener el registro más reciente de Estandares para la orden y turno dados
            $estandares = Estandares::where('packing_id', $order->id)
                ->where('turno', $turno)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($estandares) {
                // Enviar la fecha al frontend en formato "Y-m-d" para que el picker la lea
                if ($estandares->fecharealizada != null)
                    $estandares->fecharealizada = date("Y-m-d", strtotime($estandares->fecharealizada));

                $estandares = $this->getParseObject($estandares);
                $salida["code"] = 1;
                $salida["msg"] = "Processed Successfully";
                $salida["data"]["order"] = $order;
                $salida["data"]["estandares"] = $estandares;
                $salida["data"]["user"] = $usuario;
            } else {
                $estandares = $this->getNewObject($order, $usuario, $turno);
                $salida["code"] = 2;
                $salida["msg"] = "No existe estandares para esa orden";
                $salida["data"]["order"] = $order;
                $salida["data"]["estandares"] = $estandares;
                $salida["data"]["user"] = $usuario;
            }
        }
        return $salida;
    }

    // Método para avanzar a la siguiente sección
    // Método para avanzar a la siguiente sección
    public function nextSection($request, $obj)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        $request['user'] = $usuario;
        DB::beginTransaction();
        try {
            // 👇 CORREGIDO: Cambiar -> por ['id'] porque $request['order'] es array
            if ($request['order']['id'] == 0) {
                $salida['msg'] = "Error identificador requerido";
                return $salida;
            }

            // 👇 CORREGIDO: Acceder como array
            $estandares = Estandares::where('packing_id', $request['order']['id'])
                ->where('turno', $request['estandares']['turno'])
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->first();

            // 👇 CORREGIDO: Necesitas convertir los arrays a objetos o pasar todo el request
            $orderObj = (object) $request['order'];
            $estandaresObj = (object) $request['estandares'];
            
            // Pasar false para NO llenar nombres de usuario automáticamente
            $estandares = $this->getUpdateObject(
                $estandares, 
                $estandaresObj, 
                $orderObj, 
                $obj, 
                false  // 👈 NO llenar nombres automáticamente
            );
            
            // Convertir la fecha recibida a Y-m-d para guardar en la BD
            $estandares->fecharealizada = date("Y-m-d", strtotime($estandaresObj->fecharealizada));
            $estandares->save();
            $estandares->refresh();
            DB::commit();
            
            $estandares = $this->getParseObject($estandares);
            $request['estandares'] = $estandares;
            
            $salida["code"] = 1;
            $salida["msg"] = "Processed Successfully";
            $salida["data"] = array($request);
        } catch (\Exception $ex) {
            DB::rollback();
            $salida['msg'] = "Error: " . $ex->getMessage() . " en linea " . $ex->getLine();
            $salida["data"] = array($request);
        }
        return $salida;
    }
    // public function nextSection($request, $obj)
    // {
    //     $salida = [
    //         "code" => 0,
    //         "msg" => "",
    //         "data" => null
    //     ];

    //     $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
    //     $request['user'] = $usuario;
    //     DB::beginTransaction();
    //     try {
    //         if ($request['order']->id != 0) {
    //             $salida['msg'] = "Error identificador requerido";
    //             return $salida;
    //         }

    //         $estandares = Estandares::where('packing_id', $request['order']->id)
    //             ->where('turno', $request['estandares']->turno)
    //             ->whereDate('created_at', '=', date('Y-m-d'))
    //             ->first();

    //         $estandares = $this->getUpdateObject($estandares, $request['estandares'], $request['order'], $obj);
    //         // Convertir la fecha recibida (que viene en DD/MM/YYYY) a Y-m-d para guardar en la BD
    //         $estandares->fecharealizada = date("Y-m-d", strtotime($request['estandares']->fecharealizada));
    //         $estandares->save();
    //         $estandares->refresh();
    //         DB::commit();
    //         $estandares = $this->getParseObject($estandares);
    //         $request['estandares'] = $estandares;
    //         $salida["code"] = 1;
    //         $salida["msg"] = "Processed Successfully";
    //         $salida["data"] = array($request);
    //     } catch (\Exception $ex) {
    //         DB::rollback();
    //         $salida['msg'] = "Error: " . $ex->getMessage() . " en linea " . $ex->getLine();
    //         $salida["data"] = array($request);
    //     }
    //     return $salida;
    // }

    // Método para guardar o actualizar
    public function saveOrUpdate($request, $obj)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        $request['user'] = $usuario;
        DB::beginTransaction();
        try {
            $estandares = null;
            if ($request['order']->id != 0 && $request['estandares']->id != 0) {
                $estandares = Estandares::where('id', $request['estandares']->id)
                    ->where('packing_id', $request['order']->id)
                    ->where('turno', $request['estandares']->turno)
                    ->whereDate('created_at', '=', date('Y-m-d'))
                    ->first();
            }

            $estandares = $this->getUpdateObject($estandares, $request['estandares'], $request['order'], $obj);
            $estandares->save();
            $estandares->refresh();
            DB::commit();
            $estandares = $this->getParseObject($estandares);
            $request['estandares'] = $estandares;
            $salida["code"] = 1;
            $salida["msg"] = "Processed Successfully";
            $salida["data"] = array($request);
        } catch (\Exception $ex) {
            DB::rollback();
            $salida['msg'] = "Error: " . $ex->getMessage() . " en linea " . $ex->getLine();
            $salida["data"] = array($request);
        }
        return $salida;
    }

    // Crea un objeto nuevo de Estandares para una orden
    public function getNewObject($order, $usuario, $turno)
    {
        $estandares = new Estandares();
        $estandares->horas = ["", "", "", "", "", "", "", ""];
        $estandares->realizo = ["", "", "", "", "", "", "", ""];
        $estandares->verifico = ["", "", "", "", "", "", "", ""];
        $estandares->a1 = $this->getArrayCheckDefault();
        $estandares->a2 = $this->getArrayCheckDefault();
        $estandares->a3 = $this->getArrayCheckDefault();
        $estandares->a4 = $this->getArrayCheckDefault();
        $estandares->a5 = $this->getArrayCheckDefault();
        $estandares->a6 = $this->getArrayCheckDefault();
        $estandares->a7 = $this->getArrayCheckDefault();
        $estandares->a8 = $this->getArrayCheckDefault();
        $estandares->a9 = $this->getArrayCheckDefault();
        $estandares->a10 = $this->getArrayCheckDefault();
        $estandares->a11 = $this->getArrayCheckDefault();
        $estandares->a12 = $this->getArrayCheckDefault();
        $estandares->a13 = $this->getArrayCheckDefault();
        $estandares->a14 = $this->getArrayCheckDefault();
        $estandares->a15 = $this->getArrayCheckDefault();
        $estandares->a16 = $this->getArrayCheckDefault();
        $estandares->a17 = $this->getArrayCheckDefault();
        $estandares->a18 = $this->getArrayCheckDefault();
        $estandares->a19 = $this->getArrayCheckDefault();
        $estandares->presentacion = $this->getPresentacionByOrderId($order->id) ?? "";
        // $estandares->presentacion = "";
        $estandares->seccion = 0;
        $estandares->turno = $turno;
        if ($usuario['rolname'] == 'PROD')
            $estandares->opresponsable = $usuario['username'];
        else
            $estandares->opresponsable = "";
        $estandares->fecharealizada = "";
        $estandares->supervisado = "";
        $estandares->autorizado = "";
        $estandares->observaciones = "";
        $estandares->packing_id = $order->id;
        $estandares->id = 0;
        return $estandares;
    }

    public function getPresentacionByOrderId($orderId)
    {
        $presentacion = null;
        // $url = "https://192.168.6.26/wsPlantel/empaque.php";
        $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";

        try {
            $response = Http::withoutVerifying()->get($url);

            if ($response->failed()) {
                \Log::error("Error al conectar con empaque.php - Status: " . $response->status());
                return null;
            }

            $body = $response->body();
            $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
            $cleanBody = preg_replace('/[\x00-\x1F\x7F]/u', '', $cleanBody);

            $items = json_decode($cleanBody, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
                \Log::error("Error al decodificar JSON de empaque.php: " . json_last_error_msg());
                return null;
            }

            // Buscar por coincidencia en el campo `num`
            foreach ($items as $el) {
                $num = preg_replace('/\s+/', '', $el['num'] ?? '');
                $idCompare = preg_replace('/\s+/', '', $orderId);

                if (str_contains($num, $idCompare)) {
                    $presentacion = $el['presentacion'] ?? null;
                    break;
                }
            }

        } catch (\Exception $e) {
            \Log::error("Excepción al consultar empaque.php: " . $e->getMessage());
            return null;
        }

        return $presentacion;
    }


    // Crea un arreglo con valores vacíos para los campos de verificación
    public function getArrayCheckDefault()
    {
        $arreglo = array();
        for ($i = 1; $i <= 48; $i++) {
            array_push($arreglo, "");
        }
        return $arreglo;
    }

    // Actualiza el objeto Estandares con los datos del request
    // Actualiza el objeto Estandares con los datos del request
    public function getUpdateObject($estandares, $request, $order, $obj, $fillUserNames = true)
    {
        if (is_null($estandares))
            $estandares = new Estandares();

        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        
        // Solo llenar nombres si $fillUserNames es true
        if ($fillUserNames) {
            if ($usuario['rolname'] == 'PROD')
                $request->realizo[$request->seccion] = $usuario['username'];
            if ($usuario['rolname'] == 'CL' || $usuario['rolname'] == 'ACL') {
                // Solo guardar verificación si aún no es Finalizar
                if ($request->seccion < 8) {
                    $request->verifico[$request->seccion - 1] = $usuario['username'];
                }
            }
        }

        $estandares->horas = json_encode($request->horas);
        $estandares->realizo = json_encode($request->realizo);
        $estandares->verifico = json_encode($request->verifico);
        $estandares->a1 = json_encode($request->a1);
        $estandares->a2 = json_encode($request->a2);
        $estandares->a3 = json_encode($request->a3);
        $estandares->a4 = json_encode($request->a4);
        $estandares->a5 = json_encode($request->a5);
        $estandares->a6 = json_encode($request->a6);
        $estandares->a7 = json_encode($request->a7);
        $estandares->a8 = json_encode($request->a8);
        $estandares->a9 = json_encode($request->a9);
        $estandares->a10 = json_encode($request->a10);
        $estandares->a11 = json_encode($request->a11);
        $estandares->a12 = json_encode($request->a12);
        $estandares->a13 = json_encode($request->a13);
        $estandares->a14 = json_encode($request->a14);
        $estandares->a15 = json_encode($request->a15);
        $estandares->a16 = json_encode($request->a16);
        $estandares->a17 = json_encode($request->a17);
        $estandares->a18 = json_encode($request->a18);
        $estandares->a19 = json_encode($request->a19);
        $estandares->presentacion = $request->presentacion ?? $this->getPresentacionByOrderId($order->id) ?? "";

        $estandares->seccion = $request->seccion;
        $estandares->turno = $request->turno;
        
        if ($usuario['rolname'] == 'PROD')
            $estandares->opresponsable = $usuario['username'];
        else
            $estandares->opresponsable = $request->opresponsable;
            
        if ($request->seccion <= 8 && $usuario['rolname'] == 'PROD')
            $estandares->fecharealizada = date("Y-m-d", strtotime(str_replace("/", "-", $request->fecharealizada)));
            
        $estandares->supervisado = $request->supervisado;
        $estandares->autorizado = $request->autorizado;
        $estandares->observaciones = $request->observaciones;
        $estandares->packing_id = $order->id;
        return $estandares;
    }
//     public function getUpdateObject($estandares, $request, $order, $obj)
//     {
//         if (is_null($estandares))
//             $estandares = new Estandares();

//         $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
//         if ($usuario['rolname'] == 'PROD')
//             $request->realizo[$request->seccion] = $usuario['username'];
//         if ($usuario['rolname'] == 'CL' || $usuario['rolname'] == 'ACL') {
//         // Solo guardar verificación si aún no es Finalizar
//         if ($request->seccion < 8) {
//             $request->verifico[$request->seccion - 1] = $usuario['username'];
//         }
// }
//         // if ($usuario['rolname'] == 'CL' || $usuario['rolname'] == 'ACL')
//         //     $request->verifico[$request->seccion - 1] = $usuario['username'];

//         $estandares->horas = json_encode($request->horas);
//         $estandares->realizo = json_encode($request->realizo);
//         $estandares->verifico = json_encode($request->verifico);
//         $estandares->a1 = json_encode($request->a1);
//         $estandares->a2 = json_encode($request->a2);
//         $estandares->a3 = json_encode($request->a3);
//         $estandares->a4 = json_encode($request->a4);
//         $estandares->a5 = json_encode($request->a5);
//         $estandares->a6 = json_encode($request->a6);
//         $estandares->a7 = json_encode($request->a7);
//         $estandares->a8 = json_encode($request->a8);
//         $estandares->a9 = json_encode($request->a9);
//         $estandares->a10 = json_encode($request->a10);
//         $estandares->a11 = json_encode($request->a11);
//         $estandares->a12 = json_encode($request->a12);
//         $estandares->a13 = json_encode($request->a13);
//         $estandares->a14 = json_encode($request->a14);
//         $estandares->a15 = json_encode($request->a15);
//         $estandares->a16 = json_encode($request->a16);
//         $estandares->a17 = json_encode($request->a17);
//         $estandares->a18 = json_encode($request->a18);
//         $estandares->a19 = json_encode($request->a19);
//     //    $estandares->presentacion = $this->getPresentacionByOrderId($order->id) ?? "";
//         $estandares->presentacion = $request->presentacion ?? $this->getPresentacionByOrderId($order->id) ?? "";

//         $estandares->seccion = $request->seccion;
//         $estandares->turno = $request->turno;
//         if ($usuario['rolname'] == 'PROD')
//             $estandares->opresponsable = $usuario['username'];
//         else
//             $estandares->opresponsable = $request->opresponsable;
//         // Aquí se espera que el request->fecharealizada venga en formato DD/MM/YYYY
//         // Convertirlo a Y-m-d para almacenar en la BD
//         if ($request->seccion <= 8 && $usuario['rolname'] == 'PROD')
//             $estandares->fecharealizada = date("Y-m-d", strtotime(str_replace("/", "-", $request->fecharealizada)));
//         $estandares->supervisado = $request->supervisado;
//         $estandares->autorizado = $request->autorizado;
//         $estandares->observaciones = $request->observaciones;
//         $estandares->packing_id = $order->id;
//         return $estandares;
//     }

    // Parsea los campos JSON y formatea la fecha para que el picker (input type="date") pueda leerla
    public function getParseObject($estandares)
    {
        $estandares->horas = json_decode($estandares->horas, true);
        $estandares->realizo = json_decode($estandares->realizo, true);
        $estandares->verifico = json_decode($estandares->verifico, true);
        $estandares->a1 = json_decode($estandares->a1, true);
        $estandares->a2 = json_decode($estandares->a2, true);
        $estandares->a3 = json_decode($estandares->a3, true);
        $estandares->a4 = json_decode($estandares->a4, true);
        $estandares->a5 = json_decode($estandares->a5, true);
        $estandares->a6 = json_decode($estandares->a6, true);
        $estandares->a7 = json_decode($estandares->a7, true);
        $estandares->a8 = json_decode($estandares->a8, true);
        $estandares->a9 = json_decode($estandares->a9, true);
        $estandares->a10 = json_decode($estandares->a10, true);
        $estandares->a11 = json_decode($estandares->a11, true);
        $estandares->a12 = json_decode($estandares->a12, true);
        $estandares->a13 = json_decode($estandares->a13, true);
        $estandares->a14 = json_decode($estandares->a14, true);
        $estandares->a15 = json_decode($estandares->a15, true);
        $estandares->a16 = json_decode($estandares->a16, true);
        $estandares->a17 = json_decode($estandares->a17, true);
        $estandares->a18 = json_decode($estandares->a18, true);
        $estandares->a19 = json_decode($estandares->a19, true);
        // Enviar la fecha en formato "Y-m-d" para que el input type="date" la pueda leer
        if ($estandares->fecharealizada) {
            $estandares->fecharealizada = date("Y-m-d", strtotime($estandares->fecharealizada));
        }
        return $estandares;
    }
}
