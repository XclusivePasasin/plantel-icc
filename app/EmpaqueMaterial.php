<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpaqueMaterial extends Model
{
    protected $table = 'empaque_materials';
    
    protected $fillable = [
        'code', 'description', 'process', 'required_amount', 
        'unit', 'stock', 'almacen', 'lot1', 'entrega1', 
        'entrega2', 'return', 'packing_id'
    ];
}
