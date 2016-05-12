<?php

namespace Despark\Console\Commands;

use Illuminate\Console\Command;
use Despark\Console\Commands\Compilers\ResourceCompiler;
use Symfony\Component\Console\Input\InputArgument;
use File;

class ResourceCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create necessary files for CMS resource.';

    protected $identifier;

    protected $resourceOptions = [
        'image_uploads' => false,
        'migration' => false,
        'create' => false,
        'edit' => false,
        'destroy' => false,
    ];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     */
    public function fire()
    {
        $this->identifier = self::normalize($this->argument('identifier')); // event_category

        $this->askImageUploads();
        $this->askMigration();
        $this->askActions();

        $compiler = new ResourceCompiler($this, $this->identifier, $this->resourceOptions);

        $modelTemplate = $this->getTemplate('model');
        $modelTemplate = $compiler->renderModel($modelTemplate);
        $modelPath = base_path('app/Models');
        $modelFilename = $this->model_name().'.php';
        $this->saveResult($modelTemplate, $modelPath, $modelFilename);

        $configTemplate = $this->getTemplate('config');
        $configTemplate = $compiler->renderConfig($configTemplate);
        $configPath = base_path('config/admin');
        $configFilename = $this->identifier.'.php';
        $this->saveResult($configTemplate, $configPath, $configFilename);

        $controllerTemplate = $this->getTemplate('controller');
        $controllerTemplate = $compiler->renderController($controllerTemplate);
        $controllerPath = app_path('Http/Controllers/Admin');
        $controllerFilename = $this->controller_name().'.php';
        $this->saveResult($controllerTemplate, $controllerPath, $controllerFilename);

        if ($this->resourceOptions['migration']) {
            $migrationTemplate = $this->getTemplate('create_migration');
            $migrationTemplate = $compiler->renderMigration($migrationTemplate);
            $migrationPath = base_path('database/migrations');
            $migrationFilename = $this->migration_filename();
            $this->saveResult($migrationTemplate, $migrationPath, $migrationFilename);
        }
    }

    protected static function normalize($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_".strtolower($c[1]);');

        $snake = preg_replace_callback('/([A-Z])/', $func, $str);

        return str_replace(' ', '', $snake);
    }

    protected function askImageUploads()
    {
        $answer = $this->confirm('Do you need image uploads?');

        $this->resourceOptions['image_uploads'] = $answer;
    }

    protected function askMigration()
    {
        $answer = $this->confirm('Do you need migration?');

        $this->resourceOptions['migration'] = $answer;
    }

    protected function askActions()
    {
        $answer = $this->ask('Which actions do you need? [create, edit, destroy]', 'none');
        $answer = str_replace(' ', '', $answer);

        $actions = explode(',', $answer);
        $actions = array_map('strtolower', $actions);
        if (in_array('create', $actions)) {
            $this->resourceOptions['create'] = true;
        }

        if (in_array('edit', $actions)) {
            $this->resourceOptions['edit'] = true;
        }

        if (in_array('destroy', $actions)) {
            $this->resourceOptions['destroy'] = true;
        }
    }

    protected function getTemplate($type)
    {
        return file_get_contents(__DIR__.'/stubs/'.$type.'.stub');
    }

    protected function saveResult($template, $path, $filename)
    {
        $file = $path.'/'.$filename;
        if (File::exists($file)) {
            $result = $this->confirm('File "'.$filename.'" already exist in your admin bootstrap directory. Overwrite?', false);
            if (!$result) {
                return;
            }
        }

        File::put($file, $template);
        $this->info('File "'.$filename.'" was created.');
    }

    public function model_name()
    {
        return studly_case($this->identifier);
    }

    public function controller_name()
    {
        return str_plural(studly_case($this->identifier)).'Controller';
    }

    public function migration_filename()
    {
        return date('Y_m_d_His').'_create_'.str_plural($this->identifier).'_table.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'identifier',
                InputArgument::REQUIRED,
                'Identifier',
            ],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }
}
