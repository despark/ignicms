<?php

namespace Despark\Console\Commands;

use Illuminate\Console\Command;

class AppUpdateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs migrations and clearing compiled files.';

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
        exec('composer update --no-scripts');

        $this->call('clear-compiled');
        $this->call('optimize');

        $this->call('migrate', [
            '--force' => true,
        ]);

        exec('composer dumpautoload');
    }
}
