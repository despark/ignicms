<?php

namespace Despark\Cms\Facades;

use Illuminate\Support\Facades\Facade;
use Despark\Cms\Javascript\Contracts\RegistryContract;

/**
 * Class JavascriptRegistryFacade.
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
