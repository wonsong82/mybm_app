<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaptizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baptizes', function(Blueprint $table){
            $table->increments('id');

            $table->integer('user_profile_id')->unsigned();
            $table->foreign('user_profile_id', 'user_profile_baptizes_fk')
                ->references('id')->on('user_profiles')->onDelete('cascade');

            $table->tinyInteger('type')->index(); // [1:ADMISSION | 2:BAPTIZED]
            $table->date('date')->index();

            $table->timestamps();
        });





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baptizes');
    }
}
