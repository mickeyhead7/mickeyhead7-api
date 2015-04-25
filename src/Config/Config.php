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
        $base_dir = __DIR__ . '/../../config';
        $app_dir = $request->server->get('DOCUMENT_ROOT') . '/../config';

        // Set the base settings
        foreach (scandir($base_dir) as $file) {
            if (is_file($base_dir . '/' . $file)) {
                $this->set(basename($file, '.php'), require($base_dir . '/' . $file));
            }
        }

        // Get any overrides and custom config
        foreach (scandir($app_dir) as $file) {
            if (is_file($app_dir . '/' . $file)) {
                $this->set(basename($file, '.php'), require($app_dir . '/' . $file));
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