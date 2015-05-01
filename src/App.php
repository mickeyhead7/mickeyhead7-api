<?php

namespace Responsible\Api;

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
     * Path to the application routes file
     *
     * @var
     */
    private $routes_path;

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

    public function setRoutesPath($path)
    {
        $this->routes_path = $path;

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
        $path = $request->getPathInfo();

        if ($path != '/') {
            $path = rtrim($request->getPathInfo(), '/');
        }

        // Test for passed routes.php and app root fallback
        $app_dir = $request->server->get('DOCUMENT_ROOT') . '/../routes';
        if (!is_file($this->routes_path . '/routes.php') && is_file($app_dir . '/routes.php')) {
            $this->routes_path = $app_dir;
        }

        // Create the router object
        $router = new RouteCollection();
        $router->setStrategy(new UriStrategy);

        // Import the routes
        require_once($this->routes_path . '/routes.php');
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