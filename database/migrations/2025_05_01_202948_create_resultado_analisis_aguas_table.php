<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadoAnalisisAguasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultado_analisis_agua', function (Blueprint $table) {
            $table->id();
            $table->string('resultado_ph', 100)->nullable();              
            $table->string('resultado_conductividad', 100)->nullable();  
            $table->string('resultado_cloro_libre', 100)->nullable();    
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->string('usuario_crea')->nullable();
            $table->string('rol_crea')->nullable();
            $table->integer('estado')->default(1); // 1 = activo, 0 = inactivo
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultado_analisis_aguas');
    }
}
