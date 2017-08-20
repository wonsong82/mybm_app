<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoonApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soon_applications', function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->string('term');
            $table->string('status')->default('pending'); // ['pending', 'accepted', 'canceled']
            $table->boolean('need_ride')->index();
            $table->boolean('can_provide_ride')->index();
            $table->boolean('can_provide_place')->index();
            $table->string('age_preference')->index(); // ['broad', 'exact', 'both']
            $table->timestamps();


            $table->foreign('user_id', 'user_soon_application_fk')->references('id')->on('users')->onDelte('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soon_applications');
    }
}
