<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'rol_alternativo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //Get Only names from permissions 
    public function getCapsAttribute(){
        $ret = [];
        $list = $this->getPermissionsViaRoles();
        foreach($list as $c){
            array_push($ret,$c["name"]);
        }

        // Add roles as capabilities for frontend compatibility
        $roles = $this->getRoleNames();
        foreach($roles as $role){
            // Standard mapping: cap-lowercase
            $cap = 'cap-' . strtolower($role);
            array_push($ret, $cap);
            
            // Handle specific cases for hyphenated caps
            if($role == 'JefeControlCalidad') {
                 array_push($ret, 'cap-jefecontrol-calidad'); 
            }
            if($role == 'AuxControlCalidad') {
                 array_push($ret, 'cap-auxcontrol-calidad');
            }
        }

        return array_values(array_unique($ret)); 
    }
        
}
