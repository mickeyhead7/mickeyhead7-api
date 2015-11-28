<?php

namespace Mickeyhead7\Api\Scope;

use \Symfony\Component\HttpFoundation\Request;

class IncludesScope
{

    /**
     * Include parameters
     *
     * @var
     */
    protected $data;

    /**
     * Create an instance from GLOBALS
     *
     * @return IncludesScope
     * @throws ScopeException
     */
    public static function createFromGlobals()
    {
        $instance = new self();
        $data = $instance->getGlobalData();
        $instance->setData($data);

        return $instance;
    }

    /**
     * Get includes information from GLOBALS
     *
     * @return array
     * @throws ScopeException
     */
    public function getGlobalData()
    {
        $data = [];

        // Get the include querystring parameter
        $query = Request::createFromGlobals()->query->get('includes');

        // Explode and loop each include to parse
        $includes = explode(',', $query);

        if (!is_array($includes)) {
            throw new ScopeException('Malformed includes parameters.');
        }

        foreach ($includes as $include) {
            // Parse any parameters passed to the include
            $params = explode(':', $include);
            $key = array_shift($params);
            $data[$key] = [];

            // Break up each parameter and pass to the include key
            foreach ($params as $param) {
                preg_match('/([\w]+)\(([^\)]+)\)/', $param, $matches);
                array_shift($matches);
                $data[$key][$matches[0]] = $matches[1];
            }
        }

        return $data;
    }

    /**
     * Set the include scope data
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the include scope data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

}
