<?php

namespace Wonsong\DBHandler;

use Illuminate\Support\ServiceProvider;

class DBHandlerServiceProvider extends ServiceProvider
{
    protected $commands = [
        DatabaseBackupCommand::class,
        DatabaseRestoreCommand::class,
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
