<?php

namespace Mickeyhead7\Api\Resource;

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
     * @param \Mickeyhead7\Api\Models\ModelInterface $model
     * @param ResourceAdapterInterface $adapter
     */
    public function __construct(\Mickeyhead7\Api\Models\ModelInterface $model, \Mickeyhead7\Api\Resource\ResourceAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->adapter->setModel($model);
    }

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
