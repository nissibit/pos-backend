<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlapsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double("flap_12")->default('1');
            $table->double("flap_14")->default('1');
            $table->double("flap_18")->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if(Schema::hasColumn('flap_12', "products")){
                $table->dropColumn('flap_12');
            }
            if(Schema::hasColumn('flap_14', "products")){
                $table->dropColumn('flap_14');
            }
            if(Schema::hasColumn('flap_18', "products")){
                $table->dropColumn('flap_18');
            }
        });
    }
}
