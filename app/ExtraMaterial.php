<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraMaterial extends Model
{
    protected $table = 'extra_materials';

    protected $fillable = [
        'mix_order_id',
        'material_id',
        'description',
        'code',
        'lote',
        'cantidad',
        'unidad_medida',
        'almacen',
        'created_by',
    ];

    public $timestamps = false;

    // Timestamps manuales: solo created_at
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function mixOrder()
    {
        return $this->belongsTo(MixOrder::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
