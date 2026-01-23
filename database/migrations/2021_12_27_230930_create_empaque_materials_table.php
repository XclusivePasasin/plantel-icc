<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpaqueMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empaque_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('description',700);
            $table->string('process',700);
            $table->integer('required_amount');      
            $table->string('unit',100);
            $table->integer('stock');
            $table->integer('lot1');
            $table->integer('entrega1');
            $table->integer('entrega2')->nullable();
            $table->integer('return')->nullable();       
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
        Schema::dropIfExists('empaque_materials');
    }
}
