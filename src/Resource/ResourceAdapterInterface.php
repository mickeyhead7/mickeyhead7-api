<?php

namespace Mickeyhead7\Api\Resource;

interface ResourceAdapterInterface
{

    /**
     * Get a resource collection
     *
     * @param \Mickeyhead7\Api\Scope\Scope $scope
     * @param array $includes
     * @return mixed
     */
    public function getCollection(\Mickeyhead7\Api\Scope\Scope $scope);

    /**
     * Get a total count of resources in a collection
     *
     * @param \Mickeyhead7\Api\Scope\Scope $scope
     * @return mixed
     */
    public function getTotal(\Mickeyhead7\Api\Scope\Scope $scope);

    /**
     * Get a resource item
     *
     * @param $id
     * @return mixed
     */
    public function getItem($id);

}