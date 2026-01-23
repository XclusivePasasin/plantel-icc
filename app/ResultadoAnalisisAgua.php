<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultadoAnalisisAgua extends Model
{
    public $timestamps = false;
    protected $table = 'resultado_analisis_agua';
    protected $fillable = [
       'resultado_ph',
        'resultado_conductividad',
        'resultado_cloro_libre',
        'observaciones',
        'estado',
        'usuario_crea',
        'rol_crea',

    ];
    protected $casts = [
        'resultado_ph' => 'string',
        'resultado_conductividad' => 'string',
        'resultado_cloro_libre' => 'string',
        'fecha_registro' => 'datetime',
    ];
     
}
