<?php


namespace Despark\Cms\Facades;


use Despark\Cms\Javascript\Contracts\RegistryContract;
use Illuminate\Support\Facades\Facade;

/**
 * Class JavascriptRegistryFacade
 */
class JavascriptRegistryFacade extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return RegistryContract::class;
    }
}