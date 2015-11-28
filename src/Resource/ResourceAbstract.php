<?php

namespace Mickeyhead7\Api\Resource;

use \Mickeyhead7\Api\Models\ModelInterface;

abstract class ResourceAbstract
{

    /**
     * Resource data
     *
     * @var
     */
    protected $data;

    /**
     * Resource URL path
     *
     * @var
     */
    protected $path;

    /**
     * Resource data adapter, for model data retrieval
     *
     * @var ResourceAdapterInterface
     */
    private $adapter;

    /**
     * Constructor
     *
     * @param ModelInterface $model
     * @param ResourceAdapterInterface $adapter
     */
    public function __construct(ModelInterface $model, ResourceAdapterInterface $adapter, $id = null)
    {
        // Set the URI path
        $this->setPath();

        // Store any item identifier for a singular resource
        if ($id) {
            $this->id = $id;
        }

        // Set the resource adapter
        $this->adapter = $adapter;
        $this->adapter
            ->setModel($model)
            ->setScope()
            ->connect();

        // Get and store the data
        $this->setData();
    }

    abstract public function setPath();

    /**
     * Get the URL path section
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the resource data adapter
     *
     * @return ResourceAdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    abstract public function setData();

    /**
     * Get the resource data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

}
