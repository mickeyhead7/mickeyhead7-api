<?php

namespace Mickeyhead7\Api\Filters;

class Email extends FilterAbstract
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
        $value = filter_var($value, FILTER_SANITIZE_EMAIL);

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
        if(isset($config['dns_lookup']) && $config['dns_lookup']) {
            // @todo: perform dns lookup, return false if not found
        }

        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

}