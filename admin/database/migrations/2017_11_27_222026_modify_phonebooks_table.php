<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyPhonebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phonebooks', function(Blueprint $table){
            $table->string('country_code')->change();
            $table->string('area_code')->change();
            $table->string('exchange')->change();
            $table->string('line_number')->change();
            $table->string('extension_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phonebooks', function(Blueprint $table){
            $table->integer('country_code')->change(); // 4 or less
            $table->integer('area_code')->change(); // (Province/state/region) 0 to 10 digits
            $table->integer('exchange')->change(); // (prefix/switch) code 0-10 digits
            $table->integer('line_number')->change(); // 1 - 10 digits
            $table->integer('extension_number')->nullable()->change();
        });


    }
}
