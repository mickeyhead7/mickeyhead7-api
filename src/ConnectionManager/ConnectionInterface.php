<?php

namespace Responsible\Api\ConnectionManager;

interface ConnectionInterface
{

    /**
     * Make a connection
     *
     * @return mixed
     */
    public function connect();

}