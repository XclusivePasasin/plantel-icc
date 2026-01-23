<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\AnalisisAgua;

class AnalisisAguaController extends Controller
{
    //
    public function search(Request $request, $order_code){
        $analisis = new AnalisisAgua();
        $usuario= $this->obtenerUsuario($request);
        $validar = $this->vaidarPermisos($request);
        return ($validar->code==1)?$analisis->search($order_code, $usuario):json_encode($validar);
        //return $analisis->search($order_code, $request->session->get('user_cur_fullname'));
    }


    public function saveOrUpdate(Request $request){
        $validar = $this->vaidarPermisos($request);
        $analisis = new AnalisisAgua();
        $usuario= $this->obtenerUsuario($request);
        $datos['order']=json_decode(json_encode($request->order),FALSE);
        $datos['analisis']=json_decode(json_encode($request->analisis),FALSE);
        return ($validar->code==1)?$analisis->saveOrUpdate($datos, $usuario):json_encode($validar);        
    }

    public function vaidarPermisos(Request $request){
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("JefeControlCalidad")) {
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
        if (! $request->user()->hasRole("Calidad") && !$request->user()->hasRole("Mezcla") && !$request->user()->hasRole("SupCalidad") && !$request->user()->hasRole("JefeControlCalidad")) {
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
        else if($request->user()->hasRole("JefeControlCalidad")){
            $salida = [
                "email" => $request->user()->email,
                "nombre" => $request->session()->get('user_cur_fullname'),
                "rolname" => "JefeControlCalidad",
                "rolabv" => "JCCL",
                "cargo" => "JEFE CONTROL DE CALIDAD",
            ];
        }

        $respuesta= json_decode(json_encode($salida),FALSE);    
        return $respuesta; 
    }


}
