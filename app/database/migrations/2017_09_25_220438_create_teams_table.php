<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function(Blueprint $table){
            $table->increments('id');

            $table->integer('leader_id')->unsigned()->nullable();
            $table->foreign('leader_id', 'leader_teams_fk')
                ->references('id')->on('users')->onDelete('set null');

            $table->integer('term_id')->unsigned()->nullable();
            $table->foreign('term_id', 'term_team_fk')
                ->references('id')->on('terms')->onDelete('set null');

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');

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
        Schema::dropIfExists('teams');
    }
}
