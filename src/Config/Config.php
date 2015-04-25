<?php

namespace Responsible\Api\Config;

class Config
{

    /**
     * Protected data
     *
     * @var array
     */
    protected $data = [];

    public function __construct()
    {
        // Scan the config directory for configurations
        $directory = __DIR__ . '/../../config';

        foreach (scandir($directory) as $file) {
            if (is_file($directory . '/' . $file)) {
                $this->set(basename($file, '.php'), require($directory . '/' . $file));
            }
        }
    }

    /**
     * Gets a config attribute
     *
     * @param $attribute: Attribute to retrieve
     * @return array: Attribute data
     */
    public function get($attribute)
    {
        if ($attribute) {
            return $this->data[$attribute];
        }

        return null;
    }

    /**
     * Sets a new config attribute
     *
     * @param $attribute: Name of the attribute to set
     * @param null $value: Attribute data
     * @return $this
     */
    public function set($attribute, Array $value)
    {
        $this->data[$attribute] = $value;

        return $this;
    }

}