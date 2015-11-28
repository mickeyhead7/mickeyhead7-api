<?php

namespace Mickeyhead7\Api\Filters;

class Url implements FilterInterface
{

    /**
     * Sanitize a value
     *
     * @param $value
     * @param array $config
     * @return mixed
     */
    public function sanitize($value, Array $config = [])
    {
        $value = filter_var($value, FILTER_SANITIZE_URL);

        return $value;
    }

    /**
     * Validate a value
     *
     * @param $value
     * @param array $config
     * @return mixed
     */
    public function validate($value, Array $config)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

}