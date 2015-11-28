<?php

namespace Mickeyhead7\Api\Scope;

use \Symfony\Component\HttpFoundation\Request;
use \Mickeyhead7\Api\Filters\Factory as FilterFactory;

class Scope
{

    /**
     * Scope data
     *
     * @var
     */
    protected $data = [];

    /**
     * Set the scope data from GLOBALS
     *
     * @param array $scopes
     * @return $this
     */
    public function setDataFromGlobals(Array $scopes)
    {
        $query = Request::createFromGlobals()->query->all();
        $this->setData($scopes, $query);
        return $this;
    }

    /**
     * Set the scope data
     *
     * @param array $allowed_scopes
     * @return $this
     */
    public function setData(Array $scopes, $data = [])
    {
        foreach($scopes as $key => $config) {
            if(isset($data[$key])) {
                $value = $data[$key];
            } else {
                $value = isset($config['default']) ? $config['default'] : null;
            }

            // Filter the value
            $filter = new FilterFactory($config['filter']['type'], $value);
            $this->data[$key] = $filter->sanitize();
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
