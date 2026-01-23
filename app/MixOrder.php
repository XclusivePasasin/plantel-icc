<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MixOrder extends Model
{
    //Esta linea permite hacer una insercion en una sola linea, (usando array por ejemplo ...)
    //protected $fillable = ['name'];

    protected $casts = [
        'pesaje_inicio' => 'datetime:d/m/Y H:i',
        'pesaje_fin'    => 'datetime:d/m/Y H:i',
        'analisis_agua' => 'array',
    ];


    public function materials(){
        return $this->hasMany("App\Material");
    }  

    public function granel(){
        return $this->hasOne("App\Granel");
    }
}
