<?php

namespace Despark\Cms\Console\Commands;

use Illuminate\Console\Command;

class AdminUpdateProdCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:prod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs migrations and clearing compiled files on production.';

    /**
     * Create a new command instance.
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
    public function fire()
    {
        exec('composer install --no-scripts --no-dev');
        $this->call('clear-compiled');
        $this->call('optimize');

        $this->call('migrate', [
            '--force' => true,
        ]);

        exec('composer dumpautoload -o');
    }
}
