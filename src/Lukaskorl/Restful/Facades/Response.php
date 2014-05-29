<?php namespace Lukaskorl\Restful\Facades;

use Illuminate\Config\Repository as Config;
use JMS\Serializer\SerializerBuilder;

class Response extends \Illuminate\Support\Facades\Response {

    const FORMAT_XML = 'xml';
    const FORMAT_PHP = 'php';
    const FORMAT_SERIALIZED = 'serialized';
    const FORMAT_JSON = 'json';
    const FORMAT_JSONP = 'jsonp';
    const FORMAT_YAML = 'yaml';

    /**
     * @var Config
     */
    private $config;
    /**
     * @var Serializer
     */
    private $serializer;

    function __construct(Config $config)
    {
        // Initialize fields
        $this->config = $config;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Create JSON response with padding
     *
     * @param array $vars
     * @param int $status
     * @param array $header
     * @param $callback
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function jsonp(array $vars, $status = 200, array $header = [], $callback)
    {
        return $this->json($vars, $status, $header)->setCallback($callback);
    }

    /**
     * Create PHP response
     *
     * @param array $vars
     * @param int $status
     * @param array $header
     * @return \Illuminate\Http\Response
     */
    public function php(array $vars, $status = 200, array $header = [])
    {
        return $this->make(var_export($vars, true), $status, $header);
    }

    /**
     * Create XML response
     *
     * @param array $vars
     * @param int $status
     * @param array $header
     * @return \Illuminate\Http\Response
     */
    public function xml(array $vars, $status = 200, array $header = [])
    {
        return $this->make($this->serializer->serialize($vars, 'xml'), $status, $header);
    }

    /**
     * Create YAML response
     *
     * @param array $vars
     * @param int $status
     * @param array $header
     * @return \Illuminate\Http\Response
     */
    public function yaml(array $vars, $status = 200, array $header = [])
    {
        return $this->make($this->serializer->serialize($vars, 'yml'), $status, $header);
    }

    /**
     * Create serialized data response
     *
     * @param array $vars
     * @param int $status
     * @param array $header
     * @return \Illuminate\Http\Response
     */
    public function serialized(array $vars, $status = 200, array $header = [])
    {
        return $this->make(serialize($vars), $status, $header);
    }
}