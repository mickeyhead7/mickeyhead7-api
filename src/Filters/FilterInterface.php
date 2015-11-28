<?php

namespace Mickeyhead7\Api\Filters;

interface FilterInterface
{

    /**
     * Sanitize a value
     *
     * @param $value
     * @param array $config
     * @return mixed
     */
    public function sanitize($value, Array $config);

    /**
     * Validate a value
     *
     * @param $value
     * @param array $config
     * @return mixed
     */
    public function validate($value, Array $config);

}