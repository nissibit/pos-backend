<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputs', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_nuit')->nullable();
            $table->string('customer_address')->nullable();
            $table->double('subtotal')->default('0');
            $table->double('totalrate')->default('0');
            $table->double('discount')->default('0');
            $table->double('total')->default('0');
            $table->date('day');
            $table->boolean('payed')->default(false);            
            $table->string('extenso')->nullable();            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outputs');
    }
}
