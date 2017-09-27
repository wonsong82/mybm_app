<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUserProfilesTableAdditionalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('user_profiles', function(Blueprint $table){
            $table->boolean('need_ride')->index();
            $table->boolean('can_provide_ride')->index();
            $table->boolean('can_provide_place')->index();
            $table->string('age_preference')->index(); // ['broad', 'exact', 'both']
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('user_profiles', function(Blueprint $table){
            $table->dropColumn('need_ride');
            $table->dropColumn('can_provide_ride');
            $table->dropColumn('can_provide_place');
            $table->dropColumn('age_preference');
        });*/
    }
}
