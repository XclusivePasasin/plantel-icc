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
        
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];
} 