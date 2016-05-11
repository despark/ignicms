<?php

namespace Despark\Console\Commands;

use Illuminate\Console\Command;

class AppInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the application by setting up all the necessary resources.';

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
        // Generate the Application Encryption key
        $this->call('key:generate');

        // Create the migrations table
        $this->call('migrate:install');

        // Publish the packages.
        $this->call('vendor:publish', [
            '--force' => true,
            '--provider' => 'Despark\Providers\DesparkServiceProvider',
        ]);

        // Run the Migrations
        $this->call('migrate');

        // Seed the tables with dummy data
        $this->call('db:seed', [
            '--class' => 'DesparkDatabaseSeeder',
        ]);
        $this->call('db:seed');

        exec('npm install');
        exec('bower install');
        exec('gulp dev');
    }
}
