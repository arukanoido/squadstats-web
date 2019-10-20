<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Athena extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor()
    {
        return 'athena';
    }
}
