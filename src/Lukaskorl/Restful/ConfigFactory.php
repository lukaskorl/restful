<?php namespace Lukaskorl\Restful;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository;

class ConfigFactory {

    public static $configPath = null;
    public static $env = "production";

    protected static $configs = array();

    public static function make($configPath = false, $environment = false, $namespace = false)
    {
        // Filter input
        if ($configPath === false) $configPath = self::getConfigPath();
        if ($environment === false) $environment = self::getEnvironment();
        if ($namespace === false) $namespace = __DIR__."/../../config";

        // Check if there is already an instance for this configuration
        $identifier = self::getIdentifier($configPath, $environment);
        if (isset(self::$configs[$identifier])) return self::$configs[$identifier];

        // Create the configuration
        $file = new Filesystem;
        $loader = new FileLoader($file, $configPath);
        self::$configs[$identifier] = new Repository($loader, $environment);
        self::$configs[$identifier]->addNamespace("restful", $namespace);
        return self::$configs[$identifier];
    }

    /**
     * Return a unique identifier for the current setup
     *
     * @param bool $configPath
     * @param bool $environment
     * @return string
     */
    public static function getIdentifier($configPath = false, $environment = false)
    {
        // Filter input
        if ($configPath === false) $configPath = self::getConfigPath();
        if ($environment === false) $environment = self::getEnvironment();

        return md5($configPath."@".$environment);
    }

    /**
     * Get the environment set on the factory
     *
     * @return string
     */
    public static function getEnvironment()
    {
        return self::$env;
    }

    /**
     * Set the environment on the factory
     *
     * @param $env
     */
    public static function setEnvironment($env)
    {
        self::$env = $env;
    }

    /**
     * Get the current config path
     *
     * @return null|string
     */
    public static function getConfigPath()
    {
        if (self::$configPath) return self::$configPath;
        return __DIR__."/../../config";
    }

    /**
     * Set the config path on this factory
     *
     * @param $path
     */
    public static function setConfigPath($path)
    {
        self::$configPath = $path;
    }

} 