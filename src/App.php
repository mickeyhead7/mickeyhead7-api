<?php

namespace Api;

use \Symfony\Component\HttpFoundation\Request;
use \League\Route\Strategy\UriStrategy;
use \League\Route\RouteCollection;
use \Responsible\Api\Container\ContainerTrait;
use \Responsible\Api\ConnectionManager\Database;
use \Responsible\Api\Response\NotFound as ResponseNotFound;

class App
{

    /**
     * Use the container trait for access to a container
     */
    use ContainerTrait;

    /**
     * Bootrstrap the application
     *
     * @return $this
     */
    public function bootstrap()
    {
        $this
            ->makeConnections()
            ->setRoutes();

        return $this;
    }

    /**
     * Make any connections to data sources
     *
     * @return $this
     */
    public function makeConnections()
    {
        // Database connection
        $database = new Database();
        $database->connect();

        return $this;
    }

    /**
     * Set the global routes
     *
     * @return $this|\Symfony\Component\HttpFoundation\Response
     */
    public function setRoutes()
    {
        // Create a request object from the $_REQUEST globals
        $request = Request::createFromGlobals();
        $path = rtrim($request->getPathInfo(), '/');

        // Create the router object
        $router = new RouteCollection();
        $router->setStrategy(new UriStrategy);

        // Import the routes
        require_once('Routes.php');
        $dispatcher = $router->getDispatcher();

        // Dispatch a route
        try {
            $response = $dispatcher->dispatch($request->getMethod(), $path);
            $response->send();

        // No route found
        } catch (\Exception $exception) {
            $data = [
                'errors' => [
                    'message' => $exception->getMessage(),
                ],
            ];
            $response = new ResponseNotFound($data);

            return $response->send();
        }

        return $this;
    }

}