<?php

namespace Responsible\Api\Scope;

use \Symfony\Component\HttpFoundation\Request;
use \Responsible\Api\Config\Config;
use \Responsible\Api\Filters\Filter;

class Scope
{

    /**
     * Scope data
     *
     * @var
     */
    protected $data;

    public function __construct(Array $allowed_scopes)
    {
        // Set the initial scope data
        $this->setData($allowed_scopes);
    }

    /**
     * Sets the scope data
     *
     * @param array $allowed_scopes
     * @return $this
     */
    public function setData(Array $allowed_scopes)
    {
        $this->data = [];
        $config = new Config();

        $query = Request::createFromGlobals()->query->all();
        $scopes = array_merge($config->get('scope'), $allowed_scopes);

        foreach($scopes as $key => $config) {
            if(isset($query[$key])) {
                $value = $query[$key];
            } else {
                $value = $config['default'];
            }

            $class = '\Responsible\Api\Filters\\'.ucfirst($config['filter']['type']);
            $filter = new $class();
            $this->data[$key] = $filter->sanitize($value, []);
        }

        return $this;
    }

    /**
     * Gets all scope data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Gets a specific key value from the scope data
     *
     * @param $key
     * @return null
     */
    public function get($key) {
        if (isset($this->getData()[$key])) {
            return $this->getData()[$key];
        }

        return null;
    }

}