<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->unique();
            $table->string('label',50)->unique();
            $table->string('description');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('permission_id')->unsigned();
            $table->foreign('permission_id')
                    ->references("id")
                    ->on("permissions")
                    ->onUpdate("cascade")
                    ->onDelete("cascade");
            
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')
                    ->references("id")
                    ->on("roles")
                    ->onUpdate("cascade")
                    ->onDelete("cascade");
            $table->unique(['role_id','permission_id']);
            $table->rememberToken();
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
       \Schema::dropIfExists('permission_role');
       \Schema::dropIfExists('permissions');
    }
}
