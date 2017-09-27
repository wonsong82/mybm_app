<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoonUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soon_user', function(Blueprint $table){
            $table->integer('soon_id')->unsigned();
            $table->foreign('soon_id', 'soon_soon_user_fk')
                ->references('id')->on('soons')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'user_soon_user')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soon_user');
    }
}
