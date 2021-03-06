<?php

namespace Mickeyhead7\Api\Resource;

use League\Uri\Schemes\Http as HttpUri;

class Item extends ResourceAbstract
{

    /**
     * Set the data object
     *
     * @return $this
     */
    public function setData()
    {
        $this->data = $this->getAdapter()->getItem($this->id);

        return $this;
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
            $url = HttpUri::createFromServer($_SERVER);
            $path = $url->path->toArray();

            // Pop the last section of the path as this will be the current resource identifier
            array_pop($path);
            $path = implode('/', $path);
        }

        $this->path = $path;

        return $this;
    }
}
