<?php

namespace Mickeyhead7\Api\Resource;

abstract class ResourceAdapterAbstract
{

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
    public function setModel(\Mickeyhead7\Api\Models\ModelInterface $model)
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

}