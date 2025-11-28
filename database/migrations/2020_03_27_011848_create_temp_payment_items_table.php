<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempPaymentItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('temp_payment_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('way');
            $table->string('reference')->nullable();
            $table->double('amount');
            $table->double('exchanged');
            $table->string('currency')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('temp_payment_items');
    }

}
