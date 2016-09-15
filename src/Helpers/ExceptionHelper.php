<?php

namespace Despark\Cms\Helpers;

class ExceptionHelper
{
    public static function logException(\Exception $exception)
    {
        \Log::alert($exception->__toString());
    }
}
