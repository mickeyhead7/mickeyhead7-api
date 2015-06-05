<?php

namespace Mickeyhead7\Api\Scope;

use \Symfony\Component\HttpFoundation\Request;
use \Mickeyhead7\Api\Config\Config;

class Scope
{

    /**
     * Scope data
     *
     * @var
     */
    protected $data = [];

    /**
     * Creates a Scope instance from a Config object
     *
     * @return Scope
     */
    public static function createFromConfig()
    {
        $config = new Config();
        $instance = new self();
        $instance->setData($config->get('scope'));

        return $instance;
    }

    /**
     * Sets the scope data
     *
     * @param array $allowed_scopes
     * @return $this
     */
    public function setData(Array $scopes)
    {
        $query = Request::createFromGlobals()->query->all();

        foreach($scopes as $key => $config) {
            if(isset($query[$key])) {
                $value = $query[$key];
            } else {
                $value = isset($config['default']) ? $config['default'] : null;
            }

            $class = '\Mickeyhead7\Api\Filters\\'.ucfirst($config['filter']['type']);
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
