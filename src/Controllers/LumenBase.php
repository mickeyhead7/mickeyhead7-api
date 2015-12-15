<?php

namespace Mickeyhead7\Api\Controllers;

use \App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\JsonResponse;
use \Mickeyhead7\Rsvp\Manager;
use \Mickeyhead7\Api\Scope\IncludesScope;

class LumenBase extends Controller
{

    protected $model;
    protected $transformer;
    protected $resource_manager;
    protected $resource_adapter;
    protected $view;
    protected $includes_scope;

    public function __construct()
    {
        $this->includes_scope = IncludesScope::createFromGlobals();
        $this->view = new JsonResponse();
        $this->resource_manager = new Manager();
    }
}
