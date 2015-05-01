<?php

namespace Responsible\Api\Resource;

use \League\Url\Url;
use \Responsible\Api\Config\Config;

class Collection extends ResourceAbstract
{

    /**
     * Pagination data
     *
     * @var array
     */
    protected $pagination = [];

    /**
     * Scope object
     *
     * @var \Responsible\Api\Scope\Scope
     */
    private $scope;

    /**
     * Constructor
     *
     * @param \Responsible\Api\Models\ModelInterface $model
     * @param ResourceAdapterInterface $adapter
     * @param \Responsible\Api\Scope\Scope $scope
     */
    public function __construct($model, $adapter, \Responsible\Api\Scope\Scope $scope = null)
    {
        parent::__construct($model, $adapter);

        $this->setPath();
        $this->scope = $scope;
        $this->data = $adapter->getCollection($scope);
        $this->setPagination();
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
            $path = (string) $url->getPath();
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Get the scope object
     *
     * @return \Responsible\Api\Scope\Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set the pagination data
     *
     * @return $this
     */
    public function setPagination()
    {
        $total = $this->getAdapter()->getTotal($this->scope);

        // Use config defaults if not set in the request
        $page = $this->getScope()->get('page');
        $limit = $this->getScope()->get('limit');

        // Set pagination
        $pagination = $this->pagination;
        $pagination['total'] = $total;
        $pagination['count'] = $this->getData()->count();
        $pagination['per_page'] = (int) $limit;
        $pagination['current'] = (int) $page;

        // First
        if ($first = $this->getFirst()) {
            $pagination['first'] = $first;
        }

        // Previous
        if ($previous = $this->getPrevious()) {
            $pagination['previous'] = $previous;
        }

        // Next
        if ($next = $this->getNext()) {
            $pagination['next'] = $next;
        }

        // Last
        if ($last = $this->getLast()) {
            $pagination['last'] = $last;
        }

        $this->pagination = $pagination;

        return $this;
    }

    /**
     * Get the pagination data
     *
     * @return array
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Get the URL for the first result set
     *
     * @return null|string
     */
    protected function getFirst()
    {
        $url = Url::createFromServer($_SERVER);
        $query = $url->getQuery()->toArray();

        // Use config defaults if not set in the request
        $page = $this->getScope()->get('page');

        // First
        if ($page > 1) {
            $url->setPath($this->getPath());
            $query['page'] = 1;
            $url->setQuery($query);

            return (string) $url;
        }

        return null;
    }

    /**
     * Get the URL for the previous result set
     *
     * @return null|string
     */
    protected function getPrevious()
    {
        $url = Url::createFromServer($_SERVER);
        $query = $url->getQuery()->toArray();

        // Use config defaults if not set in the request
        $page = $this->getScope()->get('page');

        if ($page > 1) {
            $url->setPath($this->getPath());
            $query['page'] = $page - 1;
            $url->setQuery($query);

            return (string) $url;
        }

        return null;
    }

    /**
     * Get the URL for the next result set
     *
     * @return null|string
     */
    protected function getNext()
    {
        $url = Url::createFromServer($_SERVER);
        $query = $url->getQuery()->toArray();
        $total = $this->getAdapter()->getTotal($this->scope);

        // Use config defaults if not set in the request
        $page = $this->getScope()->get('page');
        $limit = $this->getScope()->get('limit');

        if ($page < ceil($total / $limit)) {
            $url->setPath($this->getPath());
            $query['page'] = $page + 1;
            $url->setQuery($query);

            return (string) $url;
        }

        return null;
    }

    /**
     * Get the URL for the last result set
     *
     * @return null|string
     */
    protected function getLast()
    {
        $url = Url::createFromServer($_SERVER);
        $query = $url->getQuery()->toArray();
        $total = $this->getAdapter()->getTotal($this->scope);

        // Use config defaults if not set in the request
        $page = $this->getScope()->get('page');
        $limit = $this->getScope()->get('limit');

        if ($page < ceil($total / $limit)) {
            $url->setPath($this->getPath());
            $query['page'] = (int) ceil($total / $limit);
            $url->setQuery($query);

            return (string) $url;
        }

        return null;
    }

}
