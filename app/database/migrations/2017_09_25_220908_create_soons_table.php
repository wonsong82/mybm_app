<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Soon can be independant to the team
        Schema::create('soons', function(Blueprint $table){
            $table->increments('id');

            $table->integer('leader_id')->unsigned()->nullable();
            $table->foreign('leader_id', 'leader_soon_fk')
                ->references('id')->on('users')->onDelete('set null');

            $table->integer('term_id')->unsigned()->nullable();
            $table->foreign('term_id', 'term_soon_fk')
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
        Schema::dropIfExists('soons');
    }
}
