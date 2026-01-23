<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mix_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('order_date',0);
            $table->integer('num_id')->index();//Orden Id SAE
            $table->string('product_code',300);
            $table->string('product_name',700);
            $table->string('lot_num', 100);
            $table->integer('lot_size');
            $table->timestamp('datetime_init',0)->nullable();
            $table->timestamp('datetime_end',0)->nullable();
            $table->string('cod_formula_master',300)->nullable();
            $table->string('verified_by',150)->nullable();
            $table->integer('real_performance')->nullable();
            $table->integer('materials');
            $table->integer('status');
            $table->boolean('water_check')->default(false);
            $table->string('water_firma')->nullable();
            $table->timestamp('water_date',0)->nullable();
            $table->string('observaciones',500)->nullable();
            $table->json('revisiones')->nullable();
            $table->string('user_entrega',150)->nullable();
            $table->string('user_autoriza',150)->nullable();
            $table->string('user_recibe',150)->nullable();
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
        Schema::dropIfExists('mix_orders');
    }
}
