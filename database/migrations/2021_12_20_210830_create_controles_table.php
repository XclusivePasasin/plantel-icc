<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controles', function (Blueprint $table) {
            $table->id();
            $table->string('oproduccion',10)->nullable();
            $table->string('presentacion',200)->nullable();
            $table->string('vmaximo',10)->nullable();
            $table->string('voptimo',10)->nullable();
            $table->string('vminimo',10)->nullable();
            $table->string('pmaximo',10)->nullable();
            $table->string('poptimo',10)->nullable();
            $table->string('pminimo',10)->nullable();
            $table->timestamp('fecharealizada',0)->useCurrent()->nullable();
            $table->timestamp('fecharealizada2',0)->useCurrent()->nullable();
            $table->string('llenado',200)->nullable();
            $table->string('supervisado',200)->nullable();
            $table->string('autorizado',200)->nullable();
            $table->string('observaciones',500)->nullable();
            $table->integer('seccion');
            $table->integer('turno');
            $table->json('horas');
            $table->json('realizo');
            $table->json('verifico');
            $table->json('realizo2');
            $table->json('verifico2');
            $table->json('m1');
            $table->json('m2');
            $table->json('m3');
            $table->json('m4');
            $table->json('m5');
            $table->json('m6');
            $table->json('m7');
            /*
            $table->json('m8');
            $table->json('m9');
            $table->json('m10');
            */

            $table->json('t1');
            $table->json('t2');
            $table->json('t3');
            $table->json('t4');
            $table->json('t5');
            $table->json('t6');
            $table->json('t7');
            /*
            $table->json('t8');
            $table->json('t9');
            $table->json('t10');
            */
            
            $table->json('e1');
            $table->json('e2');
            $table->foreignId('packing_id')->constrained();
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
        Schema::dropIfExists('controles');
    }
}
