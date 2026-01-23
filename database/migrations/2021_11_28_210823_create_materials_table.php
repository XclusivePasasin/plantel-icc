<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('description',700);
            $table->integer('required_amount');
            $table->string('unit',100);
            $table->decimal('stock', 10, 2)->default(0.00);
            $table->integer('almacen');
            $table->boolean('entrega1');
            $table->longText('lot_changes_history')->nullable()->comment('Historial de cambios de lote en formato JSON');
            $table->integer('lot1');
            $table->boolean('entrega2');
            $table->integer('lot2')->nullable();
            $table->foreignId('mix_order_id')->constrained();
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
        Schema::dropIfExists('materials');
    }
}
