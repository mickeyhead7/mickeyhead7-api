<?php

namespace Responsible\Api\Resource;

class DatabaseResourceAdapter extends ResourceAdapterAbstract implements ResourceAdapterInterface
{

    /**
     * Get a resource collection
     *
     * @param \Responsible\Api\Scope\Scope $scope
     * @param array $includes
     * @return mixed
     */
    public function getCollection(\Responsible\Api\Scope\Scope $scope)
    {
        $model = $this->getModel();

        // Some defaults
        $limit = 0;
        $page = 1;
        $ordering = 'id';
        $direction = 'asc';

        // Process default scopes
        foreach($scope->getData() as $key => $value) {

            if ($key === 'limit') {
                $limit = $value;
                continue;
            } elseif ($key === 'page') {
                $page = $value;
                continue;
            } elseif ($key === 'ordering') {
                $ordering = strpos($value, '.') ? $value : $model->getTable().'.'.$value;
                continue;
            } elseif ($key === 'direction') {
                $direction = $value;
                continue;
            }

            // Specified allowed scopes
            if($value) {
                $model = $model->$key($value);
            }
        }

        $data = $model
            ->orderBy($ordering, $direction)
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();

        return $data;
    }

    /**
     * Get a total count of resources in a collection
     *
     * @param \Responsible\Api\Scope\Scope $scope
     * @return mixed
     */
    public function getTotal(\Responsible\Api\Scope\Scope $scope) {
        $model = $this->getModel();

        // Process default scopes
        foreach($scope->getData() as $key => $value) {

            if ($key === 'limit' || $key === 'page' || $key === 'ordering'|| $key === 'direction') {
                continue;
            }

            // Specified allowed scopes
            if($value) {
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
    public function getItem($id, $includes = [])
    {
        $model = $this->getModel();
        $data = $model->find($id);

        return $data;
    }

}