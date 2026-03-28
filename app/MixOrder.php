<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MixOrder extends Model
{
    //Esta linea permite hacer una insercion en una sola linea, (usando array por ejemplo ...)
    //protected $fillable = ['name'];

    // Append 'materials' to JSON output
    protected $appends = ['materials'];

    protected $casts = [
        'pesaje_inicio' => 'datetime:d/m/Y H:i',
        'pesaje_fin'    => 'datetime:d/m/Y H:i',
        'analisis_agua' => 'array',
    ];


    public function mixMaterials(){
        return $this->hasMany("App\Material", 'mix_order_id');
    }

    // Accessor para exponer mixMaterials como 'materials' en JSON
    public function getMaterialsAttribute(){
        // Si ya se cargó la relación, usarla
        if ($this->relationLoaded('mixMaterials')) {
            return $this->mixMaterials;
        }
        // Si no, retornar el valor del campo materials (int) si existe
        return $this->attributes['materials'] ?? null;
    }  

    public function granel(){
        return $this->hasOne("App\Granel");
    }

    public function extraMaterials(){
        return $this->hasMany("App\ExtraMaterial", 'mix_order_id');
    }
}
