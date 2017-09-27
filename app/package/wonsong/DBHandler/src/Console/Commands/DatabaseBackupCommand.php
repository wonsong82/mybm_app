<?php

namespace Wonsong\DBHandler;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';
    //protected $signature = 'db:backup {table?* : Tables to backup, leave empty for all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tables = $this->getNamesTablesDB();

        foreach($tables as $id => $tableName){
            $this->comment("[{$id}] {$tableName}");
        }
        $tableIDs = $this->ask('Select tables by typing their IDs separated by space');

        // invalid input
        if(!preg_match('#^[\d\s]+$#', $tableIDs)){
            $this->error('Invalid table IDs');
            exit;
        }

        $tableIDs = explode(' ', trim(preg_replace('#\s+#', ' ', $tableIDs)));
        sort($tableIDs);
        $tableIDs = array_map(function($value){
            return (int)$value;
        }, $tableIDs);

        // if 0 is included, leave only one
        if($tableIDs[0] == 0){
            $tableIDs = [0];
        }


        // message it out and confirm
        $confirm = $this->confirm("You have chosen following table(s):\n[" . implode(', ', array_map(function($id) use ($tables){
            return $tables[$id];
        }, $tableIDs)) . "]\nProceed to backup?" );


        if(!$confirm){
            $this->error('Operation canceled');
            exit;
        };


        $comment = $this->ask('Add comment');



        // backup
        $location = base_path('database/backups');
        if(!is_dir($location)) mkdir($location);
//        chmod($location, '774');

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $sqlpath = $location .'/'. date('Y_m_d_His_') . $db . '.sql';
        $tablenames = $tableIDs[0] == 0 ? '' : ' ' . implode(' ', array_map(function($id) use ($tables){
            return $tables[$id];
        }, $tableIDs)) ;

        $command = "mysqldump --host={$host} --port={$port} --user={$user} --password={$pass} {$db}{$tablenames} >  {$sqlpath}";

        shell_exec($command);


        // add comment string to the file
        $line = '-- ' . json_encode([
            'tables' => implode(', ', array_map(function($id) use ($tables){
                return $tables[$id];
            }, $tableIDs)),
            'comment' => $comment
        ]);



        file_put_contents($sqlpath, $line, FILE_APPEND);




        $this->info('backup operation finished');
    }









    public function handleDeprecated()
    {
        $tables = implode(' ', $this->argument('table'));
        if($tables) $tables = ' ' . $tables;

        $location = base_path('database/backups');
        if(!is_dir($location)) mkdir($location);
        chmod($location, '774');

        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');


        $filename = count($this->argument('table')) ?
            implode('__', $this->argument('table')) . '.sql': 'all.sql';

        $sqlpath = $location .'/'. date('Y_m_d_His_') . $filename;

        $command = "mysqldump --host={$host} --port={$port} --user={$user} --password={$pass} {$db}{$tables} >  {$sqlpath}";
        shell_exec($command);

        $this->info('backup operation finished');
    }


    protected function getNamesTablesDB(){

        $database = Config::get('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES');
        $combine = "Tables_in_".$database;

        $collection = ['* ALL Tables'];

        foreach($tables as $table){
            $collection[] = $table->$combine;
        }

        return $collection;
    }
}
