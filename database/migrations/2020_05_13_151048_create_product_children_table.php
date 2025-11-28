<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("parent");
            $table->unsignedBigInteger("child");
            $table->double('quantity')->default(1);
            $table->foreign("parent")->on("products")->references("id")->onUpdate('cascade')->onDelete('cascade');
            $table->foreign("child")->on("products")->references("id")->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['parent', 'child']);
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
        Schema::dropIfExists('product_children');
    }
}
