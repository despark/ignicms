<?php

namespace Despark\Cms\Providers;

use Despark\Cms\Assets\AssetManager;
use Despark\Cms\Contracts\AssetsContract;
use Despark\Cms\Contracts\ImageContract;
use Despark\Cms\Helpers\FileHelper;
use Despark\Cms\Http\Middleware\RoleMiddleware;
use Despark\Cms\Illuminate\View\View;
use Despark\Cms\Models\Image;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use File;
use Despark\Cms\Admin\Admin;
use Mailchimp;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;

class AdminServiceProvider extends ServiceProvider
{
    use AppNamespaceDetectorTrait;

    /**
     * Artisan commands.
     *
     * @var array
     */
    protected $commands = [
        \Despark\Cms\Console\Commands\Admin\InstallCommand::class,
        \Despark\Cms\Console\Commands\Admin\ResourceCommand::class,
        \Despark\Cms\Console\Commands\File\ClearTemp::class,
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot(Router $router)
    {
        // Schedule commands after boot
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('igni:file:clear')->weeklyOn(6);
        });

        // Routes
        $router->group(['namespace' => 'Despark\Cms\Http\Controllers'], function ($router) {
            require __DIR__.'/../Http/routes.php';
        });
        // Route Middleware
        $router->middleware('role', RoleMiddleware::class);

        $this->publishes([
            __DIR__.'/../Http/resourcesRoutes.php' => app_path('Http/resourcesRoutes.php'),
        ]);

        // We need to know the namespace of the running app.
        $router->group([
            'namespace' => $this->getAppNamespace().'Http\Controllers',
            'prefix' => 'admin',
            'middleware' => 'auth',
        ],
            function () {
                if (File::exists(app_path('Http/resourcesRoutes.php'))) {
                    require app_path('Http/resourcesRoutes.php');
                }
            });

        // Register Assets
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'ignicms');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'lang');

        // Register the application commands
        $this->commands($this->commands);


        // Publish the Resources
        // Migrations
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('/migrations'),
        ], 'migrations');

        // Seeders
        $this->publishes([
            __DIR__.'/../../database/seeds/' => database_path('/seeds'),
        ], 'seeds');

        // Configs
        $this->publishes([
            __DIR__.'/../../config/' => config_path(),
        ], 'config');
        // Resources
        $this->publishes([
            __DIR__.'/../../resources/assets' => base_path('/resources/assets'),
        ], 'resources');
        $this->publishes([
            __DIR__.'/../../resources/lang' => base_path('/resources/lang'),
        ], 'resources');
        $this->publishes([
            __DIR__.'/../../resources/icomoon.json' => base_path('/resources'),
        ], 'resources');
        // Gulp
        $this->publishes([
            __DIR__.'/../../gulp/' => base_path('/gulp'),
        ], 'gulp');
        // Public
        $this->publishes([
            __DIR__.'/../../public/' => public_path(),
        ], 'public');
        // App
        $this->publishes([
            __DIR__.'/../../app/' => base_path('/app'),
        ], 'app');

        $this->publishes([
            __DIR__.'/../../.env.example' => base_path('.env.example'),
            __DIR__.'/../../package.json' => base_path('package.json'),
            __DIR__.'/../../bower.json' => base_path('bower.json'),
            __DIR__.'/../../.bowerrc' => base_path('.bowerrc'),
            __DIR__.'/../../gulpfile.js' => base_path('gulpfile.js'),
        ]);

        $configPaths = config('admin.bootstrap.paths');
        if ($configPaths) {
            foreach ($configPaths as $key => $path) {
                if (! is_dir($path)) {
                    mkdir($path, 775, true);
                }
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        /*
         * Register the service provider for the dependency.
         */
        $this->app->register('Conner\Tagging\Providers\TaggingServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Cviebrock\EloquentSluggable\SluggableServiceProvider');
        $this->app->register('Roumen\Sitemap\SitemapServiceProvider');
        $this->app->register('Rutorika\Sortable\SortableServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Spatie\Permission\PermissionServiceProvider');
        $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');

        /*
         * Create aliases for the dependency.
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('Html', 'Collective\Html\HtmlFacade');
        $loader->alias('Image', 'Intervention\Image\Facades\Image');
        $loader->alias('Agent', 'Jenssegers\Agent\Facades\Agent');

        /*
         * Assets manager
         */
        $this->app->singleton(AssetsContract::class, AssetManager::class);

        /*
         * Manually register Mailchimp
         */
        $this->app->singleton('Mailchimp', function ($app) {
            $config = $app['config']['mailchimp'];

            return new Mailchimp($config['apikey']);
        });

        /*
         * Swap Permission model implementation
         */
        $this->app->bind(Permission::class, \Despark\Cms\Models\Permission::class);
        $this->app->bind(Role::class, \Despark\Cms\Models\Role::class);

        /*
         * Image contract implementation
         */
        $this->app->bind(ImageContract::class, function ($app, $attributes = []) {
            return new Image($attributes);
        });

        /*
         * Flowjs
         */
        $this->app->bind(\Flow\File::class, function () {
            $config = new \Flow\Config([
                'tempDir' => FileHelper::getTempDirectory(),
            ]);

            return new \Flow\File($config);
        });

        /*
         * Switch View implementation
         */
        $this->app->bind(ViewContract::class, View::class);

        $this->registerFactory();
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        $this->app->singleton('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $env = new \Despark\Cms\Illuminate\View\Factory($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);

            $env->share('app', $app);

            return $env;
        });
    }
}
