<?php

namespace Mickeyhead7\Api\Filters;

abstract class FilterAbstract
{

    /**
     * Sanitize a value
     *
     * @param $value
     * @param array $config
     * @return mixed
     */
    abstract public function sanitize($value, Array $config);

    /**
     * Validate a value
     *
     * @param $value
     * @param array $config
     * @return mixed
     */
    abstract public function validate($value, Array $config);

}