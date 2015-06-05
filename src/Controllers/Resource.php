<?php

namespace Mickeyhead7\Api\Controllers;

use \Mickeyhead7\Rsvp\Resource\Collection as ResourceCollection;
use \Mickeyhead7\Rsvp\Resource\Item as ResourceItem;
use \Mickeyhead7\Rsvp\IncludeParams;
use \Mickeyhead7\Api\Resource\Collection;
use \Mickeyhead7\Api\Resource\Item;
use \Mickeyhead7\Api\Pagination\Paginator;
use \Mickeyhead7\Api\Response\NotFound as ResponseNotFound;

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
        $collection->setIncludes(new IncludeParams($this->getIncludesScope()->getData()));
        $collection->setPaginator($paginator);
        $collection->setMeta(['pagination' => $resource->getPagination()]);
        $manager = $this->getResourceManager();
        $manager->setResource($collection);

        return $this->getView()->setData($manager->createResponse())->send();
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
            $item->setIncludes(new IncludeParams($this->getIncludesScope()->getData()));
            $manager = $this->getResourceManager();
            $manager->setResource($item);

            return $this->getView()->setData($manager->createResponse())->send();
        }
    }

}
