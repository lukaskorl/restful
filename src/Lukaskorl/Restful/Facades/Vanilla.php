<?php namespace Lukaskorl\Restful\Facades;

use Illuminate\Support\Facades\Response;
use Lukaskorl\Restful\ConfigFactory;
use Lukaskorl\Restful\Restful;

class Vanilla {

    /**
     * Create an instance of restful
     *
     * @param bool $configPath
     * @param bool $environment
     * @param bool $namespace
     * @return Restful
     */
    public static function instance($configPath = false, $environment = false, $namespace = false)
    {
        return new Restful(
            ConfigFactory::make($configPath, $environment, $namespace),
            new Response()
        );
    }

    /**
     * Forward all calls on the facade to the implementation
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(self::instance(), $name), $arguments);
    }

}
