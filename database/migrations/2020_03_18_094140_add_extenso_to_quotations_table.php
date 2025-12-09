<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtensoToQuotationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('quotations', function (Blueprint $table) {
            if (!Schema::hasColumn('extenso', 'quotations')) {
                $table->string('extenso')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('quotations', function (Blueprint $table) {
            if (Schema::hasColumn('extenso', 'quotations')) {
                $table->dropColumn(['extenso']);
            }
        });
    }

}
