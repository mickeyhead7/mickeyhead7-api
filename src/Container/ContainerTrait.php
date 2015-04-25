<?php

namespace Responsible\Api\Container;

use \League\Container\Container;

trait ContainerTrait
{

    private $container;

    /**
     * Get a container instance, create a new one if one does not exist
     *
     * @return Container
     */
    public function getContainer()
    {
        if (!$this->container) {
            $this->container = new Container();
        }

        return $this->container;
    }

    /**
     * Set an item in the container
     *
     * @param $key
     * @param $object
     * @return $this
     */
    private function setContainerItem($key, $object)
    {
        $container = $this->getContainer();
        $container->add($key, $object);

        return $this;
    }

    /**
     * Get an item from the container
     *
     * @param $key
     * @return mixed|null|object
     */
    public function getContainerItem($key)
    {
        $container = $this->getContainer();

        if (!$container->isSingleton($key)) {
            return null;
        }

        return $container->get($key);
    }

}
