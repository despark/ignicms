<?php

namespace Despark\Cms\Providers;

use Despark\Cms\Javascript\Registry;
use Illuminate\Support\ServiceProvider;
use Despark\Cms\Javascript\Contracts\RegistryContract;

/**
 * Class JavascriptRegistryServiceProvider.
 */
class JavascriptServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(RegistryContract::class, Registry::class);
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [RegistryContract::class];
    }
}
