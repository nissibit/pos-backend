<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLimitdaysAndExtrapriceToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            if(!Schema::hasColumn('days', 'accounts')){
                $table->unsignedInteger('days')->default(30);
            }
            if(!Schema::hasColumn('extra_price', 'accounts')){
                $table->double('extra_price')->default(5);
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
        Schema::table('accounts', function (Blueprint $table) {
             if(Schema::hasColumn('days', 'accounts')){
                $table->dropColumn('days');
            }
             if(Schema::hasColumn('days', 'accounts')){
                $table->dropColumn('extra_price');
            }
        });
    }
}
