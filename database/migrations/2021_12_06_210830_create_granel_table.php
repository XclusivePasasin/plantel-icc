<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGranelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('granel', function (Blueprint $table) {
            $table->id();
            $table->string('producto',700);
            $table->string('lote',50)->nullable();
            $table->string('batch',50)->nullable();
            $table->string('orden',50);
            $table->timestamp('fecha_fabricacion',0)->nullable();
            $table->timestamp('fecha_expiracion',0)->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('proceso',200)->nullable();
            $table->string('cv1',50)->nullable();
            $table->string('cv2',50)->nullable();

            /*$table->string('viscosidad',50)->nullable();
            $table->string('ph',50)->nullable();
            $table->string('temperatura',50)->nullable();
            $table->string('alcohol',50)->nullable();
            $table->string('densidad',50)->nullable();*/
            $table->json('parametros');
            $table->string('responsables',300);
            $table->string('equipo',150)->nullable();
            $table->foreignId('mix_order_id')->constrained();
            $table->string('user_crea',50)->nullable();
            $table->string('user_upd',50)->nullable();
            $table->timestamps();//create_at , update_at 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('granel');
    }
}
