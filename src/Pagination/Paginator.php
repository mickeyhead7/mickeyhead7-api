<?php

namespace Mickeyhead7\Api\Pagination;

use \Mickeyhead7\Rsvp\Pagination\PaginatorInterface;
use \League\Url\Url;

class Paginator implements PaginatorInterface
{

    protected $resource;

    /**
     * Constructor
     *
     * @param \Mickeyhead7\Api\Resource\ResourceAbstract $resource
     */
    public function __construct(\Mickeyhead7\Api\Resource\ResourceAbstract $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Get the resource object
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get the current URL
     *
     * @return string
     */
    public function getSelf()
    {
        $url = Url::createFromServer($_SERVER);

        return (string) $url;
    }

    /**
     * Get the URL for the first result set
     *
     * @return string
     */
    public function getFirst()
    {
        $pagination = $this->resource->getPagination();

        if (isset($pagination['first']) && $pagination['first'] != $this->getSelf()) {
            return $pagination['first'];
        }

        return  null;
    }

    /**
     * Get the URL for the previous result set
     *
     * @return null
     */
    public function getPrevious()
    {
        $pagination = $this->resource->getPagination();

        if (isset($pagination['previous']) && $pagination['previous'] != $this->getSelf()) {
            return $pagination['previous'];
        }

        return null;
    }

    /**
     * Get the URL for the next result set
     *
     * @return null
     */
    public function getNext()
    {
        $pagination = $this->resource->getPagination();

        if (isset($pagination['next']) && $pagination['next'] != $this->getSelf()) {
            return $pagination['next'];
        }

        return  null;
    }

    /**
     * Get the URL for the last result set
     *
     * @return null
     */
    public function getLast()
    {
        $pagination = $this->resource->getPagination();

        if (isset($pagination['last']) && $pagination['last'] != $this->getSelf()) {
            return $pagination['last'];
        }

        return  null;
    }

}