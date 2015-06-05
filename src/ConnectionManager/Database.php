<?php

namespace Mickeyhead7\Api\ConnectionManager;

use \Mickeyhead7\Api\Config\Config;

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
        $connection = [
            'driver'    => getenv('DB_DRIVER'),
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_NAME'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
            'prefix'    => getenv('DB_PREFIX'),
        ];
        $capsule = new \Illuminate\Database\Capsule\Manager();
        $capsule->addConnection($connection);
        $capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $this;
    }

}
