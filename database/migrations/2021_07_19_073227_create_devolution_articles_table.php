<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolutionArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('devolution_articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('devolution_id');
            $table->unsignedBigInteger('article_id');
            $table->foreign('devolution_id')->references('id')->on('devolutions')->onUpdate('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('devolution_articles');
    }

}
