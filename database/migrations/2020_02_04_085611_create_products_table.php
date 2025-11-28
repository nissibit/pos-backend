<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode')->nullable();
            $table->string('othercode')->nullable();
            $table->string('name');
            $table->string('label')->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('unity_id')->unsigned();
            $table->double('rate');            
            $table->double('price');  
            $table->double('run_out');  
            $table->string('description')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unity_id')->references('id')->on('unities')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['barcode', 'othercode']);
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
        Schema::dropIfExists('products');
    }
}
