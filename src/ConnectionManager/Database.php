<?php

namespace Responsible\Api\ConnectionManager;

use \Responsible\Api\Config\Config;

class Database implements ConnectionInterface
{

    /**
     * Make a database connection
     *
     * @return $this
     */
    public function connect()
    {
        // Database
        $config = new Config();
        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection($config->get('database'));
        $capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $this;
    }

}
