<?php

namespace Mickeyhead7\Api\Filters;

class Integer extends FilterAbstract
{

    /**
     * Sanitize a value
     *
     * @param $value
     * @param array $config
     * @return int
     */
    public function sanitize($value, Array $config = [])
    {
        $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        // Minimum
        if (isset($config['min']) && $value < (int) $config['min']) {
            $value = (int) $config['min'];
        }

        // Maximum
        if (isset($config['max']) && $value > (int) $config['max']) {
            $value = (int) $config['max'];
        }

        return (int) $value;
    }

    /**
     * Validate a value
     *
     * @param $value
     * @param array $config
     * @return bool|mixed
     */
    public function validate($value, Array $config)
    {
        $result = filter_var($value, FILTER_VALIDATE_INT);

        // Minimum
        if (isset($config['min']) && $value < (int) $config['min']) {
            return false;
        }

        // Maximum
        if (isset($config['max']) && $value > (int) $config['max']) {
            return false;
        }

        return $result;
    }

}