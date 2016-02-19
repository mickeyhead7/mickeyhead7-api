<?php

namespace Mickeyhead7\Api\Resource;

use League\Uri\Components\Query;
use League\Uri\Schemes\Http as HttpUri;

class Collection extends ResourceAbstract
{

    /**
     * Pagination data
     *
     * @var array
     */
    protected $pagination = [];

    /**
     * Set the data object
     *
     * @return $this
     */
    public function setData()
    {
        $this->data = $this->getAdapter()->getCollection();
        $this->setPagination();

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
            $path = (string) $url->getPath();
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Set the pagination data
     *
     * @return $this
     */
    public function setPagination()
    {
        $scope = $this->getAdapter()->getScope();
        $total = $this->getAdapter()->getTotal();

        // Use config defaults if not set in the request
        $page = $scope->get('page');
        $limit = $scope->get('limit');

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
        $scope = $this->getAdapter()->getScope();
        $uri = HttpUri::createFromServer($_SERVER);
        $query = new Query($uri->getQuery());

        // Use config defaults if not set in the request
        $page = $scope->get('page');

        // First
        if ($page > 1) {
            $update_query = $query->merge('page=1');
            $new_uri = $uri->withQuery($update_query->__toString());

            return $new_uri->__toString();
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
        $scope = $this->getAdapter()->getScope();
        $uri = HttpUri::createFromServer($_SERVER);
        $query = new Query($uri->getQuery());

        // Use config defaults if not set in the request
        $page = $scope->get('page');

        if ($page > 1) {
            $update_query = $query->merge('page='.($page - 1));
            $new_uri = $uri->withQuery($update_query->__toString());

            return $new_uri->__toString();
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
        $scope = $this->getAdapter()->getScope();
        $uri = HttpUri::createFromServer($_SERVER);
        $query = new Query($uri->getQuery());
        $total = $this->getAdapter()->getTotal();

        // Use config defaults if not set in the request
        $page = $scope->get('page');
        $limit = $scope->get('limit');

        if ($page < ceil($total / $limit)) {
            $update_query = $query->merge('page='.($page + 1));
            $new_uri = $uri->withQuery($update_query->__toString());

            return $new_uri->__toString();
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
        $scope = $this->getAdapter()->getScope();
        $uri = HttpUri::createFromServer($_SERVER);
        $query = new Query($uri->getQuery());
        $total = $this->getAdapter()->getTotal();

        // Use config defaults if not set in the request
        $page = $scope->get('page');
        $limit = $scope->get('limit');

        if ($page < ceil($total / $limit)) {
            $update_query = $query->merge('page='.((int) ceil($total / $limit)));
            $new_uri = $uri->withQuery($update_query->__toString());

            return $new_uri->__toString();
        }

        return null;
    }

}
