<?php

namespace Responsible\Api\Resource;

interface ResourceAdapterInterface
{

    /**
     * Get a resource collection
     *
     * @param \Responsible\Api\Scope\Scope $scope
     * @param array $includes
     * @return mixed
     */
    public function getCollection(\Responsible\Api\Scope\Scope $scope);

    /**
     * Get a total count of resources in a collection
     *
     * @param \Responsible\Api\Scope\Scope $scope
     * @return mixed
     */
    public function getTotal(\Responsible\Api\Scope\Scope $scope);

    /**
     * Get a resource item
     *
     * @param $id
     * @return mixed
     */
    public function getItem($id);

}