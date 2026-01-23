<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{

    public function materials(){
        return $this->hasMany("App\EmpaqueMaterial");
    }
    
    public function estandares(){
        return $this->hasMany("App\Estandares");
    }

    public function controles(){
        return $this->hasMany("App\Controles");
    }

    public function inspecciones(){
        return $this->hasOne("App\Inspecciones");
    }

}
