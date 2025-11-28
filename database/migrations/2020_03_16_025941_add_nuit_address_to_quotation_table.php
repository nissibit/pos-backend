<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNuitAddressToQuotationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('quotations', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_nuit', 'quotations')) {
                $table->string('customer_nuit')->nullable();
            }
            if (!Schema::hasColumn('customer_address', 'quotations')) {
                $table->string('customer_address')->nullable();
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
            if (Schema::hasColumn('customer_nuit', 'quotations')) {
                $table->dropColumn(['customer_nuit']);
            }
            if (Schema::hasColumn('customer_address', 'quotations')) {
                $table->dropColumn(['customer_address']);
            }
        });
    }

}
