<?php

namespace Responsible\Api\Controllers;

use \Responsible\Rsvp\Resource\Collection as ResourceCollection;
use \Responsible\Rsvp\Resource\Item as ResourceItem;
use \Responsible\Api\Resource\Collection;
use \Responsible\Api\Resource\Item;
use \Responsible\Api\Pagination\Paginator;
use \Responsible\Api\Response\NotFound as ResponseNotFound;

class Resource extends Base
{

    /**
     * Returns a result set of items
     *
     * @return mixed
     */
    public function index()
    {
        // Create a new resource collection
        $resource = new Collection($this->getModel(), $this->getResourceAdapter(), $this->getScope());
        $paginator = new Paginator($resource);
        $collection = new ResourceCollection($resource->getData(), $this->getTransformer());
        $collection->setPaginator($paginator);
        $manager = $this->getResourceManager();
        $manager->setResource($collection);

        return $this->getView()->setData($manager->getResponse())->send();
    }

    /**
     * Returns an item result
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // Create a new resource item
        $resource = new Item($this->getModel(), $this->getResourceAdapter(), $id);

        // Resource not found
        if (!$resource->getData()) {
            $data = [
                'errors' => [
                    'message' => 'Resource not found',
                ],
            ];
            $response = new ResponseNotFound($data);

            return $response->send();

        // Process the resource
        } else {
            $item = new ResourceItem($resource->getData(), $this->getTransformer());
            $manager = $this->getResourceManager();
            $manager->setResource($item);

            return $this->getView()->setData($manager->getResponse())->send();
        }
    }

}
