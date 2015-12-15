<?php

namespace Mickeyhead7\Api\Filters;

class Factory
{

    public $type;
    public $value;
    public $config;

    public function __construct($type, $value, $config = [])
    {
        // Ensure a filter type is set
        if (!$type) {
            throw new FilterException('No filter type set');
        }

        $this->type = $type;
        $this->value = $value;
        $this->config = $config;
    }

    /**
     * Sanitize a value against a specified filter
     *
     * @return mixed
     * @throws FilterException
     */
    public function sanitize()
    {
        $class = __NAMESPACE__.'\\'.ucfirst($this->type);
        $filter = new $class();

        // Check for a valid filter
        if (!$filter instanceof FilterInterface) {
            throw new FilterException('Filter is not a valid instance of FilterInterface');
        }

        return $filter->sanitize($this->value, $this->config);
    }

    /**
     * Validate a value against a specified filter
     *
     * @return mixed
     * @throws FilterException
     */
    public function validate()
    {
        $class = '\App\Filters\\'.ucfirst($this->type);
        $filter = new $class();

        // Check for a valid filter
        if (!$filter instanceof FilterInterface) {
            throw new FilterException('Filter is not a valid instance of FilterInterface');
        }

        return $filter->validate($this->value, $this->config);
    }

}
