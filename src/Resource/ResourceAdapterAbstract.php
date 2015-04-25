<?php

namespace Responsible\Api\Resource;

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
     * @param \Responsible\Api\Models\ModelInterface $model
     * @return $this
     */
    public function setModel(\Responsible\Api\Models\ModelInterface $model)
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