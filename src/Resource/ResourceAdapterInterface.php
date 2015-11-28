<?php

namespace Mickeyhead7\Api\Resource;

interface ResourceAdapterInterface
{

    /**
     * Connect to a data storage source
     *
     * @return mixed
     */
    public function connect();

    /**
     * Get a resource collection
     *
     * @return mixed
     */
    public function getCollection();

    /**
     * Gets the allowed data model scope
     *
     * @return mixed
     */
    public function getScope();

    /**
     * Get a total count of resources in a collection
     *
     * @return mixed
     */
    public function getTotal();

    /**
     * Get a resource item
     *
     * @param $id
     * @return mixed
     */
    public function getItem($id);

}