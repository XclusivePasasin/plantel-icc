<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntregaDuplicada1ToMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->boolean('entrega_duplicada1')->default(0)->after('entrega1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('entrega_duplicada1');
        });
    }
}
