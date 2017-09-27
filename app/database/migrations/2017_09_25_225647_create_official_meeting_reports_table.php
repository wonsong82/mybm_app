<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficialMeetingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_meeting_reports', function(Blueprint $table){
            $table->increments('id');


            $table->integer('official_meeting_id')->unsigned();
            $table->foreign('official_meeting_id', 'omeeting_oreport_fk')
                ->references('id')->on('official_meetings')->onDelete('cascade');

            $table->date('date')->nullable();
            $table->string('place')->nullable();
            $table->text('memo')->nullable();


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
        Schema::dropIfExists('official_meeting_reports');
    }
}
