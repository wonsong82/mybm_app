<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficialMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_meetings', function(Blueprint $table){
            $table->increments('id');

            $table->integer('term_id')->unsigned()->nullable();
            $table->foreign('term_id', 'term_official_meeting_fk')
                ->references('id')->on('terms')->onDelete('set null');

            $table->string('name');
            $table->text('description');
            $table->integer('day_of_week')->unsigned();
            $table->string('default_place')->nullable();

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
        Schema::dropIfExists('official_meetings');
    }
}
