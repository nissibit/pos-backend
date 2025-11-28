<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCreditsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('credits', function (Blueprint $table) {
            if (!Schema::hasColumn('nr_requisicao', 'credits')) {
                $table->string('nr_requisicao')->nullable();
            }
            if (!Schema::hasColumn('nr_factura', 'credits')) {
                $table->string('nr_factura')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('credits', function (Blueprint $table) {
            if (Schema::hasColumn('nr_requisicao', 'credits')) {
                $table->dropColumn('nr_requisicao');
            }
            if (Schema::hasColumn('nr_factura', 'credits')) {
                $table->dropColumn('nr_factura');
            }
        });
    }

}
