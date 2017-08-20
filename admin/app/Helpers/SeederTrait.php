<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait DatabaseSeederTrait {


    /***
     * truncate table and reset the pointer to 0,
     * force delete entries with foreign key presents
     *
     * @param string|array $tablename
     */
    public function emptyTable($tablename)
    {
        $tables = is_array($tablename) ? $tablename : [$tablename];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach($tables as $table){
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    /***
     * add created_at and updated_at to the multi array data
     *
     * @param array $data
     * @return array
     */
    public function addTimestamps($data)
    {
        return array_map(function($entry){
            return array_merge($entry, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }, $data);
    }


}