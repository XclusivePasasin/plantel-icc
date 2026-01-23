<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    public function index(){
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        if(!Auth::user()->hasRole("Admin")){
            $salida["msg"] = "Operación denegada";
            return $salida;
        }

        //Buscando la lista de usuarios 
        $users = null;
        $users = User::with('roles')->get();
        if(!$users){
            $salida["msg"] = "No hay registros de usuarios";
            return $salida;
        }
        
        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"]["users"] = $users;

        return $salida;           
    }

    public function create(Request $request){
        
        $roles = DB::table('roles')->get();
        $users = User::select('email')->get();

        if (!$request->user()->hasRole("Admin")) {
            return redirect()->route('login.show');
        }
        return view('users.create',['page_title' => 'Crear', 'roles' => $roles, 'users' => $users]);
   
    }

    
    public function store(Request $request)
    {  
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->rol_alternativo = $request->rol_alternativo;

        $rol = DB::table('roles')->where('id', $request->rol)->first();
        
        if($user->save()){
           $user->assignRole($rol->name);
        }
        else{
            $salida["msg"] = "Ocurrio un problema en la creación del usuario";
            return $salida;
        }

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $request;
       
        return $salida;

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_rol = $user->getRoleNames(); 
        $permissions = $user->getPermissionsViaRoles();
        $roles = DB::table('roles')->get();
        $users = User::select('email')->get();

        return view('users.edit', ['page_title' => 'Usuario', 'user' => $user, 'permissions'=> $permissions, 'rol_user'=> $user_rol, 'roles' => $roles, 'users' => $users]);        
    }

    public function update(Request $request, $id)
    {  
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->rol_alternativo = $request->rol_alternativo;
 
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        
        if($user->save()){
            $rol = $user->getRoleNames();
            $user->removeRole($rol[0]);
            $user->assignRole($request->rol_option);
        }
        else{
            $salida["msg"] = "Ocurrio un problema en la actualización del usuario";
            return $salida;
        }
        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $user;
       
        return $salida;

    }

    public function status_user($id)
    {
        $salida = [
            "code" => 0,
            "msg" => "",
            "data" => null
        ];

        $user = User::findOrFail($id);
        
        if($user->status == 'Activo'){
            $user->status = 'Inactivo';
        }
        else{
            $user->status = 'Activo';
        }
        
        
        if(!$user->save()){
            $salida["msg"] = "Ocurrio un problema en la desactivación del usuario";
            return $salida;
        }

        $salida["code"] = 1;
        $salida["msg"] = "Processed Successfully";
        $salida["data"] = $id;

        return $salida;
    }
}
