<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlProducto extends Model
{
    protected $table = 'control_producto';

    protected $fillable = [
        'numero_orden',
        'codigo_producto',
        'nombre_producto',
        'ph_agua',
        'conductividad_agua',
        'cloro_libre_agua',
        'ph_producto',
        'especificacion_ph_producto',
        'viscosidad_producto',
        'especificacion_viscosidad_producto',
        'densidad_producto',
        'especificacion_densidad_producto',
        'apariencia_producto',
        'color_producto',
        'olor_producto',
        'observaciones_producto',
        'usuario_crea',
        'rol_crea',
        'usuario_verifica',
        'rol_verifica',
        'usuario_autoriza',
        'rol_autoriza',
        'estado',
    ];

    protected $casts = [
        // 'apariencia_producto' => 'boolean',
        // 'color_producto' => 'boolean',
        // 'olor_producto' => 'boolean',
        'estado' => 'integer',
    ];
}
