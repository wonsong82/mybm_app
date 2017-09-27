<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySoonApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soon_applications', function(Blueprint $table){
            $table->renameColumn('status', 'status_text');
            $table->renameColumn('age_preference', 'age_preference_text');
            $table->renameColumn('term', 'term_text');
        });

        Schema::table('soon_applications', function(Blueprint $table){
            $table->string('term_text')->nullable()->change();

            $table->integer('term_id')->unsigned()->nullable();
            $table->foreign('term_id', 'term_soon_application_fk')
                ->references('id')->on('terms')->onDelete('set null');

            $table->tinyInteger('status')->default(1); // [1:PENDING, 2:ACCEPTED, 3:REJECTED]
            $table->tinyInteger('age_preference'); // [1:EXACT, 2:BROAD, 3:BOTH]

            $table->string('status_text')->nullable()->change();
            $table->string('age_preference_text')->nullable()->change();

            $table->dateTime('accepted_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soon_applications', function(Blueprint $table){
            $table->dropForeign('term_soon_application_fk');
            $table->dropColumn('status');
            $table->dropColumn('age_preference');
        });

        Schema::table('soon_applications', function(Blueprint $table){
            $table->renameColumn('term_text', 'term');
            $table->renameColumn('status_text', 'status');
            $table->renameColumn('age_preference_text', 'age_preference');
            $table->dropColumn('term_id');
            $table->dropColumn('accepted_at');
        });
    }
}
