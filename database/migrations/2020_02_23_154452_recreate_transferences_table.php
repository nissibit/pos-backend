<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateTransferencesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('transferences', function (Blueprint $table) {
            if (Schema::hasColumn('transferences', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('transferences', 'quantity_from')) {
               $table->dropColumn('quantity_from');
            }
            if (Schema::hasColumn('transferences', 'quantity_to')) {
               $table->dropColumn('quantity_to');
            }
            if (Schema::hasColumn('transferences', 'quantity')) {
               $table->dropColumn('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('transferences');
    }

}
