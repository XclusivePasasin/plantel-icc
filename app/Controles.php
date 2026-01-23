<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Packing;

class Controles extends Model
{
    protected $table = "controles";


    public function search($order_code, $turno, $obj){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $user=$obj->nombre;
        //Se crea la simulacion para verificar el rol que se esta logueando el usuario
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);
        $order = null;
        // Se verifica que la orden exista
        $order = Packing::where('num_id',$order_code)->first();
        if($order){
            $controles= Controles::where('packing_id',$order->id)->where('turno', $turno)->whereDate('created_at', '=', date('Y-m-d'))->first();
            if($controles){
                if ($controles->fecharealizada!=null)
                    $controles->fecharealizada= date("d/m/Y", strtotime($controles->fecharealizada));
                $controles= $this->getParseObject($controles);
                $salida["code"] = 1;
                $salida["msg"] = "Processed Successfully";
                $salida["data"]["order"] = $order;
                $salida["data"]["controles"] = $controles;
                $salida["data"]["user"] = $usuario;
            }
            else{
                $controles= $this-> getNewObject($order, $usuario, $turno);
                $salida["code"] = 2;
                $salida["msg"] = "No existe controles para esa orden";
                $salida["data"]["order"] = $order;
                $salida["data"]["controles"] = $controles;
                $salida["data"]["user"] = $usuario;
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

            $controles = null;
            if ($request['order']->id != 0) {
                $controles = Controles::where('packing_id', $request['order']->id)->where('turno', $request['controles']->turno)->whereDate('created_at', '=', date('Y-m-d'))->first();
            }

            $accion = isset($request['accion']) ? $request['accion'] : null;

            $controles = $this->getUpdateObject($controles, $request['controles'], $request['order'], $obj, $accion);
            // 🔹 Al presionar Finalizar, se llena el campo "verifico" con el username
            // if ($controles->seccion >= 24) {
            //     $controles->verifico = array_fill(0, 24, $obj->nombre);
            // }
            $controles->save();
            $controles->refresh();
            DB::commit();
            //$controles->fecharealizada= date("d/m/Y", strtotime($controles->fecharealizada));
            //$controles->fecharealizada2= date("d/m/Y", strtotime($controles->fecharealizada2));
            $controles= $this->getParseObject($controles);
            $request['controles'] = $controles;
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


    public function getNewObject($order, $usuario, $turno){
        $controles= new Controles();
        $controles->horas= [ "","","","","","","", "","", "","","","","","","","","","", "", "", "", "","", "", "","","","", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];
        $controles->realizo= $this->getArrayFileDefault();
        $controles->verifico= $this->getArrayFileDefault();
        $controles->realizo2= $this->getArrayFileDefault();
        $controles->verifico2= $this->getArrayFileDefault();
        $controles->m1= $this->getArrayFileDefault();
        $controles->m2= $this->getArrayFileDefault();
        $controles->m3= $this->getArrayFileDefault();
        $controles->m4= $this->getArrayFileDefault();
        $controles->m5= $this->getArrayFileDefault();
        $controles->m6= $this->getArrayFileDefault();
        $controles->m7= $this->getArrayFileDefault();
        /*
        $controles->m8= $this->getArrayFileDefault();
        $controles->m9= $this->getArrayFileDefault();
        $controles->m10= $this->getArrayFileDefault();
        */

        $controles->t1= $this->getArrayFileDefault();
        $controles->t2= $this->getArrayFileDefault();
        $controles->t3= $this->getArrayFileDefault();
        $controles->t4= $this->getArrayFileDefault();
        $controles->t5= $this->getArrayFileDefault();
        $controles->t6= $this->getArrayFileDefault();
        $controles->t7= $this->getArrayFileDefault();
        /*
        $controles->t8= $this->getArrayFileDefault();
        $controles->t9= $this->getArrayFileDefault();
        $controles->t10= $this->getArrayFileDefault();
        */
        $controles->e1= $this->getArrayEspecificacionDefault();
        $controles->e2= $this->getArrayEspecificacionDefault();
        $controles->oproduccion="";
        $controles->presentacion="";
        $controles->vmaximo="";
        $controles->voptimo="";
        $controles->vminimo="";
        $controles->pmaximo="";
        $controles->poptimo="";
        $controles->pminimo="";
        $controles->seccion=0;
        $controles->turno= $turno;
        $controles->fecharealizada="";
        $controles->fecharealizada2="";
        $controles->supervisado="";
        $controles->llenado="";
        $controles->autorizado="";
        $controles->observaciones="";
        $controles->packing_id=$order->id;
        return $controles;
    }

    public function getArrayFileDefault(){
        $arreglo= array();
        for ($i = 1; $i <= 25; $i++) {
            array_push($arreglo,"");
        }
        return $arreglo;
    }

    // public function getArrayEspecificacionDefault(){
    //     $arreglo= array();
    //     for ($i = 1; $i <= 3; $i++) {
    //         array_push($arreglo,"");
    //     }
    //     return $arreglo;
    // }

    public function getArrayEspecificacionDefault() {
        return ["Según patrón", "Característico", ""];
    }

    public function getUpdateObject($controles, $request, $order, $obj,  $accion){
        if(is_null($controles))
            $controles= new Controles();
        $usuario = array('username' => $obj->nombre, 'rolname' => $obj->rolabv);

        if($usuario['rolname']=='PROD')
            if($request->seccion <=25)
                $request->realizo[$request->seccion]=$usuario['username'];
            // else if($request->seccion != 50)
            //     $request->realizo2[($request->seccion-25)]=$usuario['username'];
        if($usuario['rolname']=='CL')
        {
            if($request->seccion <=25)
            {
                if($accion != 'finalizar' && $accion != 'autorizar')
                {
                    $request->verifico[$request->seccion-1]=$usuario['username'];
                }
            }
        }

        if ($usuario['rolname'] == 'CL') {
            if ($request->seccion == 25) {
                // Verifica si la sección actual ya tiene información en "realizo"
                if ($accion == 'autorizar' && !empty($request->realizo[$request->seccion-1])) {
                    $request->verifico[$request->seccion-1] = $usuario['username'];
                }
            }
        }

            // else if($request->seccion >25 && $request->seccion != 50)
            //     $request->verifico2[($request->seccion-25)-1]=$usuario['username'];
        $controles->horas= json_encode($request->horas);
        $controles->realizo= json_encode($request->realizo);
        $controles->verifico= json_encode($request->verifico);
        $controles->realizo2= json_encode($request->realizo2);
        $controles->verifico2= json_encode($request->verifico2);
        $controles->m1=  json_encode($request->m1);
        $controles->m2=  json_encode($request->m2);
        $controles->m3=  json_encode($request->m3);
        $controles->m4=  json_encode($request->m4);
        $controles->m5=  json_encode($request->m5);
        $controles->m6=  json_encode($request->m6);
        $controles->m7=  json_encode($request->m7);
        /*
        $controles->m8=  json_encode($request->m8);
        $controles->m9=  json_encode($request->m9);
        $controles->m10= json_encode($request->m10);
        */

        $controles->t1=  json_encode($request->t1);
        $controles->t2=  json_encode($request->t2);
        $controles->t3=  json_encode($request->t3);
        $controles->t4=  json_encode($request->t4);
        $controles->t5=  json_encode($request->t5);
        $controles->t6=  json_encode($request->t6);
        $controles->t7=  json_encode($request->t7);
        /*
        $controles->t8=  json_encode($request->t8);
        $controles->t9=  json_encode($request->t9);
        $controles->t10= json_encode($request->t10);
        */
        $controles->e1= json_encode($request->e1);
        $controles->e2= json_encode($request->e2);

        $controles->presentacion=$request->presentacion;
        $controles->seccion=$request->seccion;
        $controles->turno=$request->turno;
        $controles->oproduccion = isset($request->oproduccion) ? $request->oproduccion : $order->num_id;
        $controles->llenado=$request->llenado;
        if ($request->seccion < 25 && $usuario['rolname']=='PROD'){
            if(strlen($request->fecharealizada) == 10)
                $controles->fecharealizada=date("Y-m-d", strtotime(str_replace("/", "-",$request->fecharealizada)));
            if(strlen($request->fecharealizada2) == 10)
                $controles->fecharealizada2=date("Y-m-d", strtotime(str_replace("/", "-",$request->fecharealizada2)));
            $controles->llenado=$usuario['username'];
        }
        $controles->vmaximo=$request->vmaximo;
        $controles->voptimo=$request->voptimo;
        $controles->vminimo=$request->vminimo;
        $controles->pmaximo=$request->pmaximo;
        $controles->poptimo=$request->poptimo;
        $controles->pminimo=$request->pminimo;
        $controles->supervisado=$request->supervisado;
        $controles->autorizado=$request->autorizado;
        $controles->observaciones=$request->observaciones;
        $controles->pesos_por_hora = json_encode($request->pesos_por_hora ?? []);
        $controles->packing_id=$order->id;
        return $controles;

    }

    public function getParseObject($controles){
        $controles->horas= json_decode($controles->horas,true);
        $controles->realizo= json_decode($controles->realizo,true);
        $controles->verifico= json_decode($controles->verifico,true);
        $controles->realizo2= json_decode($controles->realizo2,true);
        $controles->verifico2= json_decode($controles->verifico2,true);
        $controles->m1=  json_decode($controles->m1,true);
        $controles->m2=  json_decode($controles->m2,true);
        $controles->m3=  json_decode($controles->m3,true);
        $controles->m4=  json_decode($controles->m4,true);
        $controles->m5=  json_decode($controles->m5,true);
        $controles->m6=  json_decode($controles->m6,true);
        $controles->m7=  json_decode($controles->m7,true);
        /*
        $controles->m8=  json_decode($controles->m8,true);
        $controles->m9=  json_decode($controles->m9,true);
        $controles->m10= json_decode($controles->m10,true);
        */
        $controles->t1=  json_decode($controles->t1,true);
        $controles->t2=  json_decode($controles->t2,true);
        $controles->t3=  json_decode($controles->t3,true);
        $controles->t4=  json_decode($controles->t4,true);
        $controles->t5=  json_decode($controles->t5,true);
        $controles->t6=  json_decode($controles->t6,true);
        $controles->t7=  json_decode($controles->t7,true);
        /*
        $controles->t8=  json_decode($controles->t8,true);
        $controles->t9=  json_decode($controles->t9,true);
        $controles->t10= json_decode($controles->t10,true);
        */
        $controles->e1=  json_decode($controles->e1,true);
        $controles->e2= json_decode($controles->e2,true);

        // Formatea el timestamp a texto
        if ($controles->fecharealizada) {
            $controles->fecharealizada = date("d/m/Y", strtotime($controles->fecharealizada));
        }
        if ($controles->fecharealizada2) {
            $controles->fecharealizada2 = date("d/m/Y", strtotime($controles->fecharealizada2));
        }
        return $controles;

    }

}
