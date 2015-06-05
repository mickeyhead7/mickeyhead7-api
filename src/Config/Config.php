<?php

namespace Mickeyhead7\Api\Config;

use \Symfony\Component\HttpFoundation\Request;

class Config
{

    /**
     * Protected data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Path to the application config directory
     *
     * @var
     */
    protected $config_path;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Get the config path
        $request = Request::createFromGlobals();
        $app_dir = $request->server->get('DOCUMENT_ROOT') . '/../config';
        if (!is_dir($this->config_path) && is_dir($app_dir)) {
            $this->config_path = $app_dir;
        }

        // Get any overrides and custom config
        foreach (scandir($this->config_path) as $file) {
            if (is_file($this->config_path . '/' . $file)) {
                $this->set(basename($file, '.php'), require($this->config_path . '/' . $file));
            }
        }
    }

    /**
     * Enable the setting of the path to the config directory
     *
     * @param $path
     * @return $this
     */
    public function setConfigPath($path)
    {
        $this->config_path = $path;

        return $this;
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