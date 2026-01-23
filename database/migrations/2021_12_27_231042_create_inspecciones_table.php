<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            $table->integer('estado');
            $table->string('lote', 15);
            
            $table->timestamp('fechahoraconxtanque1', 0)->nullable();
            $table->timestamp('fechahoraconxtanque2', 0)->nullable();

            $table->string('supervisorconxtanque1')->nullable();
            $table->string('supervisorconxtanque2')->nullable();

            $table->string('ctrlcalidadconxtanque1')->nullable();
            $table->string('ctrlcalidadconxtanque2')->nullable();

            $table->string('opmaquinaconxtanque1')->nullable();
            $table->string('opmaquinaconxtanque2')->nullable();

            $table->date('rechazadosfecha1')->nullable();
            $table->date('rechazadosfecha2')->nullable();
            $table->date('rechazadosfecha3')->nullable();
            $table->date('rechazadosfecha4')->nullable();

            $table->integer('rechazadoscantidadund1')->nullable();
            $table->integer('rechazadoscantidadund2')->nullable();
            $table->integer('rechazadoscantidadund3')->nullable();
            $table->integer('rechazadoscantidadund4')->nullable();

            $table->integer('totalunidadesrechazadas')->nullable();

            $table->date('vaciosfecha1')->nullable();
            $table->date('vaciosfecha2')->nullable();
            $table->date('vaciosfecha3')->nullable();
            $table->date('vaciosfecha4')->nullable();

            $table->float('vacioscantidadkgs1', 8, 2)->nullable();
            $table->float('vacioscantidadkgs2', 8, 2)->nullable();
            $table->float('vacioscantidadkgs3', 8, 2)->nullable();
            $table->float('vacioscantidadkgs4', 8, 2)->nullable();

            $table->float('totalkilogramosvacios', 8, 2)->nullable();
            $table->string('productoterminado1')->nullable();
            $table->string('productoterminado2')->nullable();
            $table->integer('pt')->nullable();
            $table->integer('ptotal')->nullable();
            $table->float('rendimientomezcla', 8,2)->nullable();
            $table->string('consumobobina', 15)->nullable();
            
            $table->foreignId('packing_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspecciones');
    }
}
