<?php

namespace Yaro\Turbo\Facades;

use Illuminate\Support\Facades\Facade;


class Turbo extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'yaro_turbo';
    } // end getFacadeAccessor

}