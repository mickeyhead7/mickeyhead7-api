<?php

namespace Responsible\Api\Config;

use \Symfony\Component\HttpFoundation\Request;

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
        $request = Request::createFromGlobals();
        $dir = $request->server->get('DOCUMENT_ROOT') . '/../config';

        // Get any overrides and custom config
        foreach (scandir($dir) as $file) {
            if (is_file($dir . '/' . $file)) {
                $this->set(basename($file, '.php'), require($dir . '/' . $file));
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