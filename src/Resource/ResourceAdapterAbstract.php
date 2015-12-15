<?php

namespace Mickeyhead7\Api\Resource;

use \Mickeyhead7\Api\Scope\Scope;
use \Mickeyhead7\Api\Models\ModelInterface;

abstract class ResourceAdapterAbstract
{
    private $scope = [];

    protected $filters = [
        'limit' => [
            'default' => 20,
            'filter' => [
                'type'      => 'integer',
                'config'    => [
                    'minimum' => 1
                ]
            ]
        ],
        'page' => [
            'default'   => 1,
            'filter'    => [
                'type' => 'integer'
            ]
        ],
        'sort' => [
            'default'   => 'id.desc',
            'filter'    => [
                'type' => 'string'
            ]
        ],
        'includes' => [
            'default'   => null,
            'filter'    => [
                'type' => 'string'
            ]
        ],
    ];

    /**
     * Data model
     *
     * @var
     */
    protected $model;

    /**
     * Set the data model
     *
     * @param \Mickeyhead7\Api\Models\ModelInterface $model
     * @return $this
     */
    public function setModel(ModelInterface $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the data model
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the resource scope
     *
     * @return $this
     */
    public function setScope()
    {
        // Merge default scope filters with filters custom to the model
        $this->scope = new Scope();
        $this->scope->setDataFromGlobals(array_merge($this->filters, $this->getModel()->filters));

        return $this;
    }

    /**
     * Get the resource scope
     *
     * @return array
     */
    public function getScope()
    {
        return $this->scope;
    }

}