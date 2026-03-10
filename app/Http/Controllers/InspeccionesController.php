<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspecciones;
use App\Packing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\ValidacionTanque;

class InspeccionesController extends Controller
{
   

    public function search(Request $request, $order_code)
    {
        $inspecciones = new Inspecciones();
        $usuario = $this->obtenerUsuario($request);
        $validar = $this->vaidarPermisos($request);

        if ($validar->code != 1) {
            return json_encode($validar);
        }

        // 📌 Código original y normalizado
        $originalOrderCode = trim($order_code);
        $normalizedOrderCode = preg_replace('/\s+/', '', $order_code);

        // 1️⃣ Validar existencia de tanque autorizado y que la reconexión (si existe) también esté autorizada
        $validacion = ValidacionTanque::whereRaw("REPLACE(numero_orden, ' ', '') = ?", [$normalizedOrderCode])->first();

        if (!$validacion || $validacion->estado != 3) {
            return response()->json([
                "code" => 0,
                "msg"  => "⚠️ La orden no ha sido autorizada en el módulo de tanque. Debe completar la validación primero."
            ]);
        }

        // ❌ Bloqueo si hay una reconexión en curso pero no autorizada
        if ($validacion->reconexion_estado > 0 && $validacion->reconexion_estado < 3) {
            return response()->json([
                "code" => 0,
                "msg"  => "⚠️ Hay una RECONEXIÓN pendiente de autorizar por Control de Calidad. Bloqueado hasta que se complete el flujo."
            ]);
        }

        // 2️⃣ Buscar inspección en BD
        $salida = $inspecciones->search($order_code, $usuario);
        if (is_string($salida)) {
            $salida = json_decode($salida, true);
        }

        $inspeccion = $salida['data']['inspecciones'] ?? null;

        // 🔥 OBTENER CONSUMO DE BOBINA DINÁMICAMENTE DESDE EMPAQUE
        $consumoBobina = 0;
        $orderModel = Packing::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode])
                            ->with('empaqueMaterials')
                            ->first();
        if ($orderModel) {
            foreach ($orderModel->empaqueMaterials as $mat) {
                if (isset($mat->tipo_prod) && strtolower(trim($mat->tipo_prod)) === 'bobina') {
                    $entrega1 = floatval($mat->entrega1 ?? 0);
                    $entrega2 = floatval($mat->entrega2 ?? 0);
                    $devolucion = floatval($mat->return ?? 0);
                    $consumoBobina = ($entrega1 + $entrega2) - $devolucion;
                    break;
                }
            }
        }
        
        if (isset($salida['data']['inspecciones'])) {
            $salida['data']['inspecciones']['consumobobina'] = $consumoBobina;
        }

        // 🧩 Si ya existe una inspección guardada en BD → devolver tal cual (con el consumo calculado sobrescrito en RAM para mostrarlo real-time)
        if ($inspeccion && !empty($inspeccion['id'])) {
            $salida["data"]["tanque"] = $validacion;
            return response()->json($salida);
        }

        // 🧩 Si no existe inspección, calcular datos desde PACKING
        $entregas = Packing::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalizedOrderCode])->first();
        $totalCajas = 0;
        $totalUnidades = 0;

        if ($entregas && isset($entregas->entregas)) {
            $entregasData = json_decode($entregas->entregas, true);
            foreach ($entregasData as $entrega) {
                $cantidad = str_replace(' ', '', $entrega['cantidad']); // limpiar espacios
                if ($cantidad) {
                    $partes = explode('/', $cantidad);
                    $cajas = isset($partes[0]) ? (int)$partes[0] : 0;
                    $unidades = isset($partes[1]) ? (int)$partes[1] : 0;
                    $totalCajas += $cajas;
                    $totalUnidades += $unidades;
                }
            }
        }

        $salida["data"]["inspecciones"]["productoterminado1"] = $totalCajas;
        $salida["data"]["inspecciones"]["productoterminado2"] = $totalUnidades;

        // 3️⃣ Buscar UXC y capacidad en WS
        try {
            $url = "https://data.industriascuscatlan.com:7322/wsPlantel/empaque.php";
            $json = @file_get_contents($url);
            if ($json === false) {
                throw new \Exception("No se pudo acceder al servicio remoto.");
            }

            $json = preg_replace('/^\xEF\xBB\xBF/', '', $json);
            $json = preg_replace('/^\x{FEFF}/u', '', $json);
            $json = preg_replace('/[\x00-\x1F\x7F]/u', '', $json);
            $dataWS = json_decode($json, true);

            if (is_array($dataWS)) {
                foreach ($dataWS as $registro) {
                    if (!isset($registro['num'])) continue;

                    $numWS = strtoupper(trim($registro['num']));
                    $numWS = preg_replace('/[–—−‒]/u', '-', $numWS);
                    $numWS = preg_replace('/\s+/', '', $numWS);

                    $frontendCode = strtoupper(preg_replace('/\s+/', '', $originalOrderCode));

                    if ($numWS === $frontendCode) {
                        $salida["data"]["inspecciones"]["uxc"] = floatval($registro['uxc'] ?? 0);
                        $salida["data"]["inspecciones"]["capacidad"] = floatval($registro['total_units'] ?? 0);
                        break;
                    }
                }
            }
        } catch (\Exception $e) {
            $salida["data"]["inspecciones"]["uxc"] = 0;
            $salida["data"]["inspecciones"]["capacidad"] = 0;
            $salida["data"]["inspecciones"]["error_ws"] = "Error WS: " . $e->getMessage();
        }

        // 4️⃣ Copiar datos de orden base si existen
        if (isset($salida['data']['order'])) {
            $order = $salida['data']['order'];
            $salida["data"]["inspecciones"]["lot_size"] = $order['lot_size'] ?? 0;
            $salida["data"]["inspecciones"]["total_units"] = $order['total_units'] ?? 0;
        }

        // 5️⃣ Calcular PT
        $cajas = floatval($salida["data"]["inspecciones"]["productoterminado1"] ?? 0);
        $unidadesSueltas = floatval($salida["data"]["inspecciones"]["productoterminado2"] ?? 0);
        $uxc = floatval($salida["data"]["inspecciones"]["uxc"] ?? 0);
        $pt = ($cajas * $uxc) + $unidadesSueltas;

        $salida["data"]["inspecciones"]["pt"] = $pt;
        $salida["data"]["inspecciones"]["estado"] = 0;
        $salida["data"]["tanque"] = $validacion;

        return response()->json($salida);
    }



    public function saveOrUpdate(Request $request){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];
        $usuario= $this->obtenerUsuario($request);
        $validar = $this->vaidarPermisos($request);
        $usuario = array('username' => $usuario->nombre, 'rolname' => $usuario->rolabv);

       if($validar->code==1){
        DB::beginTransaction();
        try{
            $inspecciones = Inspecciones::where('packing_id', $request->packing_id)->first();
            $order = Packing::where('id', $request->packing_id)->first();
            if(!$inspecciones){
                $inspecciones = new Inspecciones();
                $inspecciones->estado = 1;
            }

            if($inspecciones->estado == 2){
                $inspecciones->estado = 3;
            }
                $inspecciones->lote = $request->lote;
                $inspecciones->num_id = $request->num_id;

                $inspecciones->tanque = $request->tanque;

                $inspecciones->fechahoraconxtanque1 = $request->fechahoraconxtanque1 ? date("Y-m-d H:i", strtotime(strtr($request->fechahoraconxtanque1, '/', '-'))) : NULL;
                // $inspecciones->fechahoraconxtanque2 = $request->fechahoraconxtanque2 ? date("Y-m-d H:i", strtotime(strtr($request->fechahoraconxtanque2, '/', '-'))) : NULL;

                $inspecciones->supervisorconxtanque1 = $request->supervisorconxtanque1;
                // $inspecciones->supervisorconxtanque2 = $request->supervisorconxtanque2;

                $inspecciones->ctrlcalidadconxtanque1 = $request->ctrlcalidadconxtanque1;
                // $inspecciones->ctrlcalidadconxtanque2 = $request->ctrlcalidadconxtanque2;

                $inspecciones->opmaquinaconxtanque1 = $request->opmaquinaconxtanque1;
                // $inspecciones->opmaquinaconxtanque2 = $request->opmaquinaconxtanque2;

                $inspecciones->rechazadosfecha1 = $request->rechazadosfecha1 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha1, '/', '-'))) : NULL;
                $inspecciones->rechazadosfecha2 = $request->rechazadosfecha2 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha2, '/', '-'))) : NULL;
                $inspecciones->rechazadosfecha3 = $request->rechazadosfecha3 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha3, '/', '-'))) : NULL;
                $inspecciones->rechazadosfecha4 = $request->rechazadosfecha4 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha4, '/', '-'))) : NULL;

                $inspecciones->rechazadoscantidadund1 = $request->rechazadoscantidadund1;
                $inspecciones->rechazadoscantidadund2 = $request->rechazadoscantidadund2;
                $inspecciones->rechazadoscantidadund3 = $request->rechazadoscantidadund3;
                $inspecciones->rechazadoscantidadund4 = $request->rechazadoscantidadund4;

                $inspecciones->totalunidadesrechazadas =  $request->totalunidadesrechazadas;

                $inspecciones->vaciosfecha1 = $request->vaciosfecha1 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha1, '/', '-'))) : NULL;
                $inspecciones->vaciosfecha2 = $request->vaciosfecha2 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha2, '/', '-'))) : NULL;
                $inspecciones->vaciosfecha3 = $request->vaciosfecha3 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha3, '/', '-'))) : NULL;
                $inspecciones->vaciosfecha4 = $request->vaciosfecha4 ? date("Y-m-d", strtotime(strtr($request->rechazadosfecha4, '/', '-'))) : NULL;

                $inspecciones->vacioscantidadkgs1 = $request->vacioscantidadkgs1;
                $inspecciones->vacioscantidadkgs2 = $request->vacioscantidadkgs2;
                $inspecciones->vacioscantidadkgs3 = $request->vacioscantidadkgs3;
                $inspecciones->vacioscantidadkgs4 = $request->vacioscantidadkgs4;

                $inspecciones->totalkilogramosvacios = $request->totalkilogramosvacios;

                $inspecciones->productoterminado1 = $request->productoterminado1;
                $inspecciones->productoterminado2 = $request->productoterminado2;

                $inspecciones->pt = $request->pt;
                $inspecciones->ptotal = $request->ptotal;
                $inspecciones->capacidad = $request->capacidad;
                $inspecciones->rendimientomezcla = $request->rendimientomezcla;
                $inspecciones->consumobobina = $request->consumobobina;

                $inspecciones->packing_id = $request->packing_id;

                $inspecciones->save();
                $inspecciones->refresh();
                DB::commit();

                $salida["code"] = 1;
                $salida["msg"] = "Processed Successfully";
                $salida["data"]["order"] = $order;
                $salida["data"]["inspecciones"] = $inspecciones;
                $salida["data"]["user"] = $usuario;

        }catch(\Exception $ex){
            DB::rollback();
            $salida['msg'] = "Error: " . $ex->getMessage()." en linea ".$ex->getLine(); //for debugin
        }
        }

        return $salida;
    }

    public function approve($order, $accion){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $inspecciones = Inspecciones::where('packing_id', $order)->first();
        $order = Packing::where('id', $order)->first();
        $estado = $inspecciones->estado;
        $user = Auth::user();
        $rol = $user->getRoleNames();
        $usuario = array('username' => $user->name, 'rolname' => $rol[0]);

        if($estado == 1 && $accion=='verificar'){
            if($rol[0]=='SupProduccion'){
                $inspecciones->supervisorconxtanque1 = $user->name;
            }
            if($rol[0]=='Calidad' || $rol[0]=='AuxControlCalidad'){
                $inspecciones->ctrlcalidadconxtanque1 = $user->name;
            }
            $inspecciones->estado = 2;
            $inspecciones->update();
        }
        else if($estado == 3 && $accion=='verificar'){
            if($rol[0]=='SupProduccion'){
                $inspecciones->supervisorconxtanque2 = $user->name;
            }
            if($rol[0]=='Calidad'){
                $inspecciones->ctrlcalidadconxtanque2 = $user->name;
            }
            $inspecciones->estado = 4;
            $inspecciones->update();
        }
        else if(($estado == 2 || $estado == 4) && $accion=='finalizar'){
            if($rol[0]=='SupProduccion' && !$inspecciones->supervisorconxtanque1){
                $inspecciones->supervisorconxtanque1 = $user->name;
            }
            if($rol[0]=='SupProduccion' && !$inspecciones->supervisorconxtanque2){
                $inspecciones->supervisorconxtanque2 = $user->name;
            }
            if(($rol[0]=='Calidad' || $rol[0]=='AuxControlCalidad') && !$inspecciones->ctrlcalidadconxtanque1){
                $inspecciones->ctrlcalidadconxtanque1 = $user->name;
            }
            if($rol[0]=='Calidad' && !$inspecciones->ctrlcalidadconxtanque2){
                $inspecciones->ctrlcalidadconxtanque2 = $user->name;
            }
            $inspecciones->estado = 5;
            $inspecciones->update();
        }
        else if($estado == 5 && $accion=='autorizar'){
            if($rol[0]=='SupProduccion' && !$inspecciones->supervisorconxtanque1){
                $inspecciones->supervisorconxtanque1 = $user->name;
            }
            if($rol[0]=='SupProduccion' && !$inspecciones->supervisorconxtanque2){
                $inspecciones->supervisorconxtanque2 = $user->name;
            }
            if(($rol[0]=='Calidad' || $rol[0]=='AuxControlCalidad') && !$inspecciones->ctrlcalidadconxtanque1){
                $inspecciones->ctrlcalidadconxtanque1 = $user->name;
            }
            if($rol[0]=='Calidad' && !$inspecciones->ctrlcalidadconxtanque2){
                $inspecciones->ctrlcalidadconxtanque2 = $user->name;
            }
            $inspecciones->estado = 6;
            $inspecciones->update();
        }
        $inspecciones->refresh();
        DB::commit();

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"]["order"] = $order;
        $salida["data"]["inspecciones"] = $inspecciones;
        $salida["data"]["user"] = $usuario;

        return $salida;
    }

    public function vaidarPermisos(Request $request){

      if (!$request->user()->hasRole("Produccion") && !$request->user()->hasRole("Calidad") && !$request->user()->hasRole("SupProduccion") && !$request->user()->hasRole("AuxControlCalidad")) {
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
