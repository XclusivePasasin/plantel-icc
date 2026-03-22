<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    // Append 'materials' to JSON output
    protected $appends = ['materials'];

    public function empaqueMaterials(){
        return $this->hasMany("App\EmpaqueMaterial", 'packing_id');
    }
    
    // Accessor para exponer empaqueMaterials como 'materials' en JSON
    public function getMaterialsAttribute(){
        // Si ya se cargó la relación, usarla
        if ($this->relationLoaded('empaqueMaterials')) {
            return $this->empaqueMaterials;
        }
        // Si no, retornar el valor del campo materials (int) si existe
        return $this->attributes['materials'] ?? null;
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
