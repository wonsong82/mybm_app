<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressbooks', function(Blueprint $table){
            $table->increments('id');

            $table->string('line1'); // Street address, P.O. box, company name, c/o
            $table->string('line2')->nullable(); // Apartment, suite, unit, building, floor, etc.
            $table->string('city');
            $table->string('state'); // State/Province
            $table->string('zip'); // Zip/PostalCode
            $table->string('country');

            $table->timestamps();

            $table->integer('user_profile_id')->unsigned();
            $table->foreign('user_profile_id', 'user_profile_addressbook_fk')->references('id')->on('user_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addressbooks');
    }
}
