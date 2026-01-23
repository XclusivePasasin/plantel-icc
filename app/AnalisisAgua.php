<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\MixOrder;

class AnalisisAgua extends Model
{
    protected $table = "analisis_agua";
    // Function que verifica si existe un analisis de agua para una orden de produccion

    public function search($turno, $obj)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];
        $user=$obj->nombre;
        //Se crea la simulacion para verificar el rol que se esta logueando el usuario
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        
        // Se verifica que la orden exista
        
        if (true) {
            $analisis = AnalisisAgua::where('turno', $turno)->whereDate('created_at', '=', date('Y-m-d'))->first();
            if ($analisis) {
                $order = MixOrder::whereDate('order_date', '=', $analisis->created_at->format('Y-m-d'))->first();
                $especificacion=  $this->getEspecificacionObject($analisis->especificacion);
                if ($usuario['rolname'] == 'CL' && $user != 'NA'){
                    $analisis->user_crea = $user;
                    $analisis->rol_crea = $obj->cargo;
                }
                if ($usuario['rolname'] == 'SCL' && $user != 'NA'){
                    $analisis->user_verifica = $user;
                    $analisis->rol_verifica = $obj->cargo;
                }
                if (($usuario['rolname'] == 'JCCL' || $usuario['rolname'] == 'CL') && $user != 'NA'){
                    $analisis->user_autoriza = $user;
                    $analisis->rol_autoriza = $obj->cargo;
                }              
                $salida["code"] = 1;
                $salida["msg"] = "Processed Successfully";
                $salida["data"]["order"] = $order;
                $salida["data"]["analisis"] = $analisis;
                $salida["data"]["user"] = $usuario;
                $salida["data"]["especificacion"] = $especificacion;
            } else {
                $analisis = $this->getNewObject($turno);
                $especificacion=  $this->getNewEspecificacionObject();
                if ($usuario['rolname'] == 'CL'){
                    $analisis->user_crea = $user;
                    $analisis->rol_crea = $obj->cargo;
                }

                $salida["code"] = 2;
                $salida["msg"] = "No existe analisis para esa orden";
                $salida["data"]["analisis"] = $analisis;
                $salida["data"]["user"] = $usuario;
                $salida["data"]["especificacion"] = $especificacion;
            }
        }
        return $salida;
    }

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

            $analisis = null;
            if ($request['analisis']->turno != 0) {
                //$analisis = AnalisisAgua::where('mix_order_id', $request['order']->id)->first();
                $analisis = AnalisisAgua::where('turno', $request['analisis']->turno)->whereDate('created_at', '=', date('Y-m-d'))->first();
                
            }

            $analisis = $this->getUpdateObject($analisis, $request['analisis'], $request['analisis']->turno, $obj);
            $this->checkFirmas($analisis,$obj);
            $analisis->save();
            $analisis->refresh();
            DB::commit();
            
            $especificacion=  $this->getEspecificacionObject($analisis->especificacion);
            $request['analisis'] = $analisis;
            $request['especificacion'] = $especificacion;
            $salida["code"] = 1;
            $salida["msg"] = "Processed Successfully";
            $salida["data"] = array($request);
        } catch (\Exception $ex) {
            DB::rollback();
            //$salida["msg"] = "Error en la operación, consulte soporte técnico.";
            $salida['msg'] = "Error: " . $ex->getMessage() . " en linea " . $ex->getLine(); //for debugin   
            $salida["data"] = array($request);
        }

        return $salida;
    }

    public function checkFirmas($analisis,$obj){
        $user=$obj->nombre;
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);

        if ($usuario['rolname'] == 'CL' && $user != 'NA' && $analisis->status == 1 ){
            $analisis->user_crea = $user;
            $analisis->rol_crea = $obj->cargo;
        }
        if (($usuario['rolname'] == 'SCL' || $usuario['rolname'] == 'CL') && $user != 'NA' && $analisis->status == 2){
            $analisis->user_verifica = $analisis->user_crea;
            $analisis->rol_verifica = $analisis->rol_crea;
        }
        if (($usuario['rolname'] == 'JCCL') && $user != 'NA' && $analisis->status == 3){
            $analisis->user_autoriza = $user;
            $analisis->rol_autoriza = $obj->cargo;
        }
    }

    public function getNewObject($turno)
    {
        $analisis = new AnalisisAgua();
        $analisis->phagua = "";
        $analisis->conductividad = "";
        $analisis->clibre = "";
        $analisis->phproducto = "";
        $analisis->viscosidad = "";
        $analisis->densidad = "";
        $analisis->apariencia = "";
        $analisis->color = "";
        $analisis->olor = "";
        $analisis->status = 0;
        $analisis->turno = $turno;
        $analisis->observaciones = null;
        /*
        $analisis->especificacion = "CONTROL DE AGUA 
        PH: 
        CONDUCTIVIDAD: 
        CLORO LIBRE: 
        ---------------------------------------------------- 
CONTROL DE PRODUCTO 
        PH: 
        VISCOSIDAD: 
        DENSIDAD: 
        APARIENCIA: 
        COLOR: 
        OLOR:   ";
        */
        $analisis->especificacion ="";
        $analisis->user_crea = "";
        $analisis->rol_crea = "";
        $analisis->crea_date = "";
        $analisis->user_verifica = "";
        $analisis->rol_verifica = "";
        $analisis->verifica_date = "";
        $analisis->user_autoriza = "";
        $analisis->rol_autoriza = "";
        $analisis->autoriza_date = "";
        //$analisis->mix_order_id = $idOrder;
        return $analisis;
    }

    public function getUpdateObject($analisis, $request, $turno, $obj)
    {
        if (is_null($analisis)) {
            $analisis = new AnalisisAgua();
            $analisis->crea_date = date('Y-m-d');
        }
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        if ($usuario['rolname'] == 'CIP')
            $analisis->crea_date = date('Y-m-d');
        if ($usuario['rolname'] == 'CL' && $request->status != 0)
            $analisis->verifica_date = date('Y-m-d');;
        if ($usuario['rolname'] == 'SCL')
            $analisis->autoriza_date = date('Y-m-d');;

        $analisis->phagua = $request->phagua;
        $analisis->conductividad = $request->conductividad;
        $analisis->clibre = $request->clibre;
        $analisis->phproducto = $request->phproducto;
        $analisis->viscosidad = $request->viscosidad;
        $analisis->densidad = $request->densidad;
        $analisis->apariencia = $request->apariencia;
        $analisis->color = $request->color;
        $analisis->olor = $request->olor;
        $analisis->status = $request->status;
        $analisis->turno = $request->turno;
        $analisis->observaciones = $request->observaciones;
        $analisis->especificacion = $request->especificacion;
        $analisis->user_crea = $request->user_crea;
        $analisis->rol_crea = $request->rol_crea;
        //$analisis->crea_date=$request->crea_date;
        $analisis->user_verifica = $request->user_verifica;
        $analisis->rol_verifica = $request->rol_verifica;
        //$analisis->verifica_date=$request->verifica_date;
        $analisis->user_autoriza = $request->user_autoriza;
        $analisis->rol_autoriza = $request->rol_autoriza;
       // $analisis->autoriza_date = $request->autoriza_date;
        //$analisis->mix_order_id = $order->id;
        return $analisis;
    }

    public function getEspecificacionObject($cadena)
    {
        $pieces = explode("PH:", $cadena);
        $phagua = explode("CONDUCTIVIDAD:", $pieces[1]);
        $phagua = trim($phagua[0]);
        $data['phagua'] = $phagua;



        $pieces1 = explode("CONDUCTIVIDAD:", $cadena);
        $c1 = explode("CLORO LIBRE:", $pieces1[1]);
        $c1 = trim($c1[0]);
        $data['conductividad'] = $c1;


        preg_match('/CLORO LIBRE:\s*([^\n]*)/', $cadena, $matches);
        $data['clorolibre'] = trim($matches[1]);


        $pieces3 = explode("PH:", $cadena);
        $c3 = explode("VISCOSIDAD:", $pieces3[2]);
        $c3 = trim($c3[0]);
        $data['phproducto'] = $c3;

        $pieces4 = explode("VISCOSIDAD:", $cadena);
        $c4 = explode("DENSIDAD:", $pieces4[1]);
        $c4 = trim($c4[0]);
        $data['viscosidad'] = $c4;


        $pieces5 = explode("DENSIDAD:", $cadena);
        $c5 = explode("APARIENCIA:", $pieces5[1]);
        $c5 = trim($c5[0]);
        $data['densidad'] = $c5;

        $pieces6 = explode("APARIENCIA:", $cadena);
        $c6 = explode("COLOR:", $pieces6[1]);
        $c6 = trim($c6[0]);
        $data['apariencia'] = $c6;


        $pieces7 = explode("COLOR:", $cadena);
        $c7 = explode("OLOR:", $pieces7[1]);
        $c7 = trim($c7[0]);
        $data['color'] = $c7;

        $pieces8 = explode("OLOR:", $cadena);
        $c8 = trim($pieces8[2]);
        $data['olor'] = $c8;
        $especificacion = json_decode(json_encode($data), FALSE);
        return $especificacion;
    }


    public function getNewEspecificacionObject()
    {
        $data['phagua'] = "5.5 - 8.0";
        $data['conductividad'] = "<= 20 μS/cm";
        $data['clorolibre'] = "1.5 - 2.5 ppm";
        $data['phproducto'] = "";
        $data['viscosidad'] = "";
        $data['densidad'] = "";
        $data['apariencia'] = "IGUAL AL ESTANDAR";
        $data['color'] = "IGUAL AL ESTANDAR";
        $data['olor'] = "IGUAL AL ESTANDAR";
        $especificacion = json_decode(json_encode($data), FALSE);
        return $especificacion;
    }
}
