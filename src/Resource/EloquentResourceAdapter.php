<?php

namespace Mickeyhead7\Api\Resource;

class EloquentResourceAdapter extends ResourceAdapterAbstract implements ResourceAdapterInterface
{

    /**
     * Determines if a connection exists
     */
    public function isConnected()
    {
        return \DB::connection()->getDatabaseName();
    }

    /**
     * Make the database connection
     *
     * @return $this
     */
    public function connect()
    {
        $capsule = new \Illuminate\Database\Capsule\Manager();

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

        $capsule->addConnection($connection);
        $capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $this;
    }

    /**
     * Get a resource collection
     *
     * @param \Mickeyhead7\Api\Scope\Scope $scope
     * @param array $includes
     * @return mixed
     */
    public function getCollection()
    {
        $scope = $this->getScope();
        $model = $this->getModel();
        $table = $model->getTable();

        // Some defaults
        $limit = 0;
        $page = 1;
        $sort = 'id';
        $direction = 'asc';

        // Process scopes
        foreach($scope->getData() as $key => $value) {

            if ($key === 'limit') {
                $limit = $value;
                continue;
            } elseif ($key === 'page') {
                $page = $value;
                continue;
            } elseif ($key === 'sort') {
                $parts = explode('.', $value);
                $sort = isset($parts[0]) ? $parts[0] : $sort;
                $direction = isset($parts[1]) ? $parts[1] : $direction;
                continue;
            } elseif ($key === 'includes') {
                continue;
            }

            // Specified allowed scopes
            if($value) {
                $model = $model->$key($value);
            }
        }

        // Custom sort method
        if (method_exists($model, 'scopeSort'.ucfirst($sort))) {
            $model = $model->{'sort' . $sort}($direction);
        }

        // Default sort
        else {
            $sort = $table.'.'.$sort;
            $model = $model->orderBy($sort, $direction);
        }

        $data = $model
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return $data;
    }

    /**
     * Get a total count of resources in a collection
     *
     * @param \Mickeyhead7\Api\Scope\Scope $scope
     * @return mixed
     */
    public function getTotal()
    {
        $scope = $this->getScope();
        $model = $this->getModel();

        // Process default scopes
        foreach($scope->getData() as $key => $value) {

            if ($key === 'limit'
                || $key === 'page'
                || $key === 'sort'
                || $key === 'direction'
                || $key === 'includes'
            ) {
                continue;
            }

            // Specified allowed scopes
            if ($value) {
                $model = $model->$key($value);
            }
        }

        $total = $model->count();

        return $total;
    }

    /**
     * Get a resource item
     *
     * @param $id
     * @param array $includes
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getItem($id, $column = null, $includes = [])
    {
        return $this
            ->getModel()
            ->find($id);
    }

}