<?php

namespace Mickeyhead7\Api\ConnectionManager;

interface ConnectionInterface
{

    /**
     * Make a connection
     *
     * @return mixed
     */
    public function connect();

}