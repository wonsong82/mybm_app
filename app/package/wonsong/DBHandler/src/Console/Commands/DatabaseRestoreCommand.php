<?php

namespace Wonsong\DBHandler;

use Illuminate\Console\Command;

class DatabaseRestoreCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore Database';

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
        // get files and ask user to select
        $databases = $this->getDatabaseFiles();

        foreach($databases as $id => $database){
            $this->comment("[{$id}] {$database['name']} | comment: {$database['comment']} | tables: {$database['tables']}");
        }
        $id = $this->ask('Select database to restore');

        if(!preg_match('#^[\d+]$#', $id)){
            $this->error('Invalid database ID');
            exit;
        }

        // confirm, and ask if migrate is done
        $chosen = $databases[$id];


        $confirm = $this->confirm("You have chosen table(s) to restore from {$chosen['name']}:\n[{$chosen['tables']}]\n\nMake sure you have finished migration, if not, operation cannot be reversed.\nProceed?");

        if(!$confirm){
            $this->error('Operation canceled');
            exit;
        }

        // restore
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');

        $command = "mysql --host={$host} --port={$port} --user={$user} --password={$pass} {$db} < {$chosen['path']}";

        shell_exec($command);

        $this->info('restore operation finished');
    }


    private function getDatabaseFiles()
    {
        $folder = base_path('database/backups');
        $files = glob($folder . '/*.sql');

        return array_map(function($file){
            $line = $this->readlastline($file);

            if(preg_match('#^-- {#', $line)){
                $line = json_decode(str_replace('-- ', '', $line));
                $tables = $line->tables;
                $comment = $line->comment;
            }
            else {
                $tables = 'unknown';
                $comment = 'unkonwn';
            }

            return [
                'path' => $file,
                'name' => str_replace('.sql', '', basename($file)),
                'tables' => $tables,
                'comment' => $comment
            ];
        }, $files);
    }


    private function readlastline($file)
    {
        $fp = @fopen($file, "r");
        $pos = -1;
        $t = " ";
        while ($t != "\n") {
            fseek($fp, $pos, SEEK_END);
            $t = fgetc($fp);
            $pos = $pos - 1;
        }
        $t = fgets($fp);
        fclose($fp);
        return $t;
    }
}
