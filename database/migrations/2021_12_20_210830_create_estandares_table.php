<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstandaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estandares', function (Blueprint $table) {
            $table->id();
            $table->string('opresponsable',300)->nullable();
            $table->string('supervisado',200)->nullable();
            $table->string('autorizado',200)->nullable();
            $table->string('observaciones',500)->nullable();
            $table->timestamp('fecharealizada',0)->useCurrent()->nullable();
            $table->integer('seccion');
            $table->integer('turno');
            $table->string('presentacion',200)->nullable();
            $table->json('horas');
            $table->json('realizo');
            $table->json('verifico');
            $table->json('a1');
            $table->json('a2');
            $table->json('a3');
            $table->json('a4');
            $table->json('a5');
            $table->json('a6');
            $table->json('a7');
            $table->json('a8');
            $table->json('a9');
            $table->json('a10');
            $table->json('a11');
            $table->json('a12');
            $table->json('a13');
            $table->json('a14');
            $table->json('a15');
            $table->json('a16');
            $table->json('a17');
            $table->json('a18');
            $table->json('a19');
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
        Schema::dropIfExists('estandares');
    }
}
