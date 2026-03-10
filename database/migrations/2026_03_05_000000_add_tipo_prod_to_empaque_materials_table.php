<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoProdToEmpaqueMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empaque_materials', function (Blueprint $table) {
            if (!Schema::hasColumn('empaque_materials', 'tipo_prod')) {
                $table->string('tipo_prod', 100)->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empaque_materials', function (Blueprint $table) {
            $table->dropColumn('tipo_prod');
        });
    }
}
