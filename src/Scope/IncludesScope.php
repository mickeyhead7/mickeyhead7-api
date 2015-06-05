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
     * Constructor
     */
    public function __construct()
    {
        $this->setData();
    }

    /**
     * Set the include scope data
     *
     * @return $this
     */
    public function setData()
    {
        $this->data = [];

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
            $this->data[$key] = [];

            // Break up each parameter and pass to the include key
            foreach ($params as $param) {
                preg_match('/([\w]+)\(([^\)]+)\)/', $param, $matches);
                array_shift($matches);
                $this->data[$key][$matches[0]] = $matches[1];
            }
        }

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
