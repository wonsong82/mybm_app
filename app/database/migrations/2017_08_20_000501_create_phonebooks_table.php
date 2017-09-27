<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phonebooks', function(Blueprint $table){
            $table->increments(('id'));

            $table->integer('country_code'); // 4 or less
            $table->integer('area_code'); // (Province/state/region) 0 to 10 digits
            $table->integer('exchange'); // (prefix/switch) code 0-10 digits
            $table->integer('line_number'); // 1 - 10 digits
            $table->integer('extension_number')->nullable();

            $table->timestamps();

            $table->integer('user_profile_id')->unsigned();
            $table->foreign('user_profile_id', 'user_profile_phonebook_fk')->references('id')->on('user_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phonebooks');
    }
}
