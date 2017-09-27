<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoonTeamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soon_team', function(Blueprint $table){
            $table->integer('soon_id')->unsigned();
            $table->foreign('soon_id', 'soon_soon_team_fk')
                ->references('id')->on('soons')->onDelete('cascade');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id', 'team_soon_team_fk')
                ->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soon_team');
    }
}
