<?php

namespace Responsible\Api\Filters;

class String extends FilterAbstract
{

    /**
     * Sanitize a value
     *
     * @param $value
     * @param array $config
     * @return mixed|string
     */
    public function sanitize($value, Array $config = [])
    {
        $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);

        // Maximum characters
        if(isset($config['max_length']) && strlen($value) > (int) $config['max_length']) {
            $value = substr($value, 0, $config['max_length']);
        }

        return $value;
    }

    /**
     * Validate a value
     *
     * @param $value
     * @param array $config
     * @return bool
     */
    public function validate($value, Array $config)
    {
        $result = is_string($value);

        // Maximum characters
        if(isset($config['max_length']) && strlen($value) > (int) $config['max_length']) {
            return false;
        }

        return $result;
    }

}