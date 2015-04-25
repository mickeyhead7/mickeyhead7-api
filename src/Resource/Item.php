<?php

namespace Responsible\Api\Resource;

use \League\Url\Url;

class Item extends ResourceAbstract
{

    /**
     * Constructor
     *
     * @param \Responsible\Api\Models\ModelInterface $model
     * @param ResourceAdapterInterface $adapter
     * @param $id
     */
    public function __construct($model, $adapter, $id)
    {
        parent::__construct($model, $adapter);

        $this->setPath();
        $this->data = $this->getAdapter()->getItem($id);
    }

    /**
     * Set the path section of the URL
     *
     * @param null $path
     * @return $this
     */
    public function setPath($path = null)
    {
        if (!$path)
        {
            $url = Url::createFromServer($_SERVER);
            $path = $url->getPath()->toArray();

            // Pop the last section of the path as this will be the current resource identifier
            array_pop($path);
            $path = implode('/', $path);
        }

        $this->path = $path;

        return $this;
    }

}
