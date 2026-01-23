<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packings', function (Blueprint $table) {
            $table->id();
            $table->date('order_date');
            $table->integer('num_id')->index();//Orden Id SAE
            $table->string('product_code',300);
            $table->string('product_name',700);
            $table->integer('lot_num')->nullable();
            $table->integer('lot_size');
            $table->integer('total_units');
            $table->integer('performance_teorico')->nullable();
            $table->integer('performance')->nullable();
            $table->json('times')->nullable();
            $table->json('operarios')->nullable();
            $table->json('entregas')->nullable();
            $table->integer('materials');
            $table->integer('status');            
            $table->string('observations',500)->nullable();
            $table->string('user_entrega',150)->nullable();
            $table->string('user_autoriza',150)->nullable();
            $table->string('user_recibe',150)->nullable();
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
        Schema::dropIfExists('packings');
    }
}
