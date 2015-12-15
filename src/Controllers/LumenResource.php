<?php

namespace Mickeyhead7\Api\Controllers;

use \Illuminate\Support\Facades\Request;
use \Mickeyhead7\Rsvp\Resource\Collection as ResourceCollection;
use \Mickeyhead7\Rsvp\Resource\Item as ResourceItem;
use \Mickeyhead7\Rsvp\IncludeParams;
use \Mickeyhead7\Api\Resource\Collection;
use \Mickeyhead7\Api\Resource\Item;
use \Mickeyhead7\Api\Pagination\Paginator;
use \Mickeyhead7\Api\Response\NotFound as ResponseNotFound;

class LumenResource extends LumenBase
{

    /**
     * Returns a result set of items
     *
     * @return mixed
     */
    public function index()
    {
        // Create a new resource collection
        $resource = new Collection($this->model, $this->resource_adapter);
        $paginator = new Paginator($resource);
        $collection = new ResourceCollection($resource->getData(), $this->transformer);
        $collection->setIncludeParams(new IncludeParams($this->includes_scope->getData()));
        $collection->setPaginator($paginator);
        $collection->setMeta(['pagination' => $resource->getPagination()]);
        $manager = $this->resource_manager;
        $manager->setResource($collection);

        return $this->view->setData($manager->createResponse())->send();
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
        $resource = new Item($this->model, $this->resource_adapter, $id);

        // Resource not found
        if (!$resource->getData()) {
            $data = [
                'errors' => [
                    'message' => 'Resource not found',
                ],
            ];
            $response = new ResponseNotFound($data);

            return $response->send();

        }

        // Process the resource
        $item = new ResourceItem($resource->getData(), $this->transformer);
        $item->setIncludeParams(new IncludeParams($this->includes_scope->getData()));
        $manager = $this->resource_manager;
        $manager->setResource($item);

        return $this->view->setData($manager->createResponse())->send();
    }

    public function create(Request $request)
    {
        $this->model->create($request->all());
    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
