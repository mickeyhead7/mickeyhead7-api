<?php

namespace Responsible\Api\Response;

use \Symfony\Component\HttpFoundation\JsonResponse;

class NotFound extends JsonResponse
{

    /**
     * Constructor
     *
     * @param null $data
     * @param int $status
     * @param array $headers
     */
    public function __construct($data = null, $status = 404, $headers = [])
    {
        // Prepare the parent response
        parent::__construct($data, $status, $headers);
    }

}
