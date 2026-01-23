<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisProductosTable extends Migration
{
    
    public function up()
    {
        Schema::create('control_producto', function (Blueprint $table) {
            $table->id();
            $table->string('numero_orden', 100);
            $table->string('ph_agua', 50)->nullable();
            $table->string('conductividad_agua', 50)->nullable();
            $table->string('cloro_libre_agua', 50)->nullable();
            $table->string('ph_producto', 50)->nullable();
            $table->string('especificacion_ph_producto', 50)->nullable();
            $table->string('viscosidad_producto', 50)->nullable();
            $table->string('especificacion_viscosidad_producto', 50)->nullable();
            $table->string('densidad_producto', 50)->nullable();
            $table->string('especificacion_densidad_producto', 50)->nullable();
            $table->boolean('apariencia_producto')->default(0);
            $table->boolean('color_producto')->default(0);
            $table->boolean('olor_producto')->default(0);
            $table->text('observaciones_producto')->nullable();
            $table->string('usuario_crea', 100)->nullable();
            $table->string('rol_crea', 100)->nullable();
            $table->string('usuario_verifica', 100)->nullable();
            $table->string('rol_verifica', 100)->nullable();
            $table->string('usuario_autoriza', 100)->nullable();
            $table->string('rol_autoriza', 100)->nullable();
            $table->unsignedTinyInteger('estado')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('control_producto');
    }
}
