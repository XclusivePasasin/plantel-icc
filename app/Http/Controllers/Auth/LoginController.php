<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Auth;

class LoginController extends Controller
{
	public function __construct(){

	}

    public function showLogin(){
        return view('auth.login');
    }

    public function login(){
        //Redirecciona automaticamente
        $credentials = $this->validate(request(),[
            'email' => 'required|string|min: 2', //poner aqui para email 
            'password' => 'required|string|min:2'
        ]);

        $email = request()->email;
        $password = request()->password;        

        Auth::attempt(['email' => $email, 'password' => $password]);

        if(Auth::check()){
            
            if(auth()->user()->status == 'Inactivo'){
                Auth::logout();
                return redirect('/login')->withErrors(["inactive_user"=>"Su cuenta está INACTIVA, comuníquese con el administrador"])->withInput(request(['email','password']));
            }

            //Obteniendo Lista de permisos 
            $role_id = Auth::user()->roles->first()->id;
            $menus = DB::table('menus')->where('role_id',$role_id)->get()->unique('menu');
            
            session([
                'role_cur_user' => Auth::user()->getRoleNames()[0],
                'user_cur_id' => 501,//este debe ser unica para cada usuario 
                'user_cur_fullname' => Auth::user()->name,
                'rol_alternativo' => Auth::user()->rol_alternativo,
                'email_cur_user' => $email,
                'main_menu' => $menus
            ]);


            return redirect()->route('admin.home');          
        }

        return back()->withErrors(["no_match"=>"Credenciales incorrectas"])->withInput(request(['email','password']));
    }

    public function logout(){

        Auth::logout();
        session()->forget('role_cur_user');
        session()->forget('email_cur_user');
        session()->forget('user_cur_id');
        session()->forget('user_cur_fullname');
        session()->forget('main_menu');

        return redirect()->route('login.show');
    }


}
