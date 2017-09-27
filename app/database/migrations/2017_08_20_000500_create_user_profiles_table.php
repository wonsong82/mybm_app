<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function(Blueprint $table){
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->string('name')->nullable()->index();
            $table->string('avatar')->nullable(); // avatar image
            $table->date('birthday')->nullable()->index();
            $table->string('gender')->nullable()->index(); // ['male', 'female']

            $table->timestamps();

            $table->foreign('user_id', 'user_user_profile_fk')
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
        Schema::dropIfExists('user_profiles');
    }
}
