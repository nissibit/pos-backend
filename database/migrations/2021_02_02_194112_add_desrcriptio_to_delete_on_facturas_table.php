<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesrcriptioToDeleteOnFacturasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('destroy_reason')->nullable();
            $table->string('destroy_username')->nullable();
            $table->datetime('destroy_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn(["destroy_reason", "destroy_username", "destroy_date"]);
        });
    }

}
