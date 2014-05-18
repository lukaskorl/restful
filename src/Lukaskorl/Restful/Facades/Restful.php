<?php namespace Lukaskorl\Restful\Facades;

use Illuminate\Support\Facades\Facade;

class Restful extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'restful';
    }

} 