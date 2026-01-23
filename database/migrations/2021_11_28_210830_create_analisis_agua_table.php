<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalisisAguaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis_agua', function (Blueprint $table) {
            $table->id();
            $table->string('phagua',50)->nullable();
            $table->string('conductividad',50)->nullable();
            $table->string('clibre',50)->nullable();
            $table->string('phproducto',50)->nullable();
            $table->string('viscosidad',50)->nullable();
            $table->string('densidad',50)->nullable();
            $table->string('apariencia',50)->nullable();
            $table->string('color',50)->nullable();
            $table->string('olor',50)->nullable();
            $table->integer('status');
            $table->integer('turno');
            $table->string('observaciones',300)->nullable();
            $table->string('especificacion',500);
            $table->string('user_crea',50)->nullable();
            $table->string('rol_crea',50)->nullable();
            $table->timestamp('crea_date',0)->nullable();
            $table->string('user_verifica',50)->nullable();
            $table->string('rol_verifica',50)->nullable();
            $table->timestamp('verifica_date',0)->nullable();
            $table->string('user_autoriza',50)->nullable();
            $table->string('rol_autoriza',50)->nullable();
            $table->timestamp('autoriza_date',0)->nullable();
            //$table->foreignId('mix_order_id')->constrained();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analisis_agua');
    }
}
