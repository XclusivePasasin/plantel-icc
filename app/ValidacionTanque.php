<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ValidacionTanque extends Model
{
    protected $table = 'validaciones_tanque';
     protected $guarded = []; // permite asignación masiva
    public $timestamps = false; // desactiva timestamps si no tienes created_at / updated_at

    protected $fillable = [
        'numero_orden',
        'fecha_hora',
        'operaria',
        'supervisor',
        'control_calidad',
        'lote',
        'numero_tanque',
        'codigo_empaque',
        'estado',
        'reconexion_fecha_hora',
        'reconexion_lote',
        'reconexion_numero_tanque',
        'reconexion_operaria',
        'reconexion_supervisor',
        'reconexion_control_calidad',
        'reconexion_estado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];
} 