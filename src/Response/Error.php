<?php

namespace Mickeyhead7\Api\Response;

use \Symfony\Component\HttpFoundation\JsonResponse;

class Error extends JsonResponse
{

    /**
     * Constructor
     *
     * @param null $data
     * @param int $status
     * @param array $headers
     */
    public function __construct($data = null, $status = 500, $headers = [])
    {
        // Prepare the parent response
        parent::__construct($data, $status, $headers);
    }

}
