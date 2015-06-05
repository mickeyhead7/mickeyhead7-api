<?php

namespace Mickeyhead7\Api;

use \Symfony\Component\HttpFoundation\Request;
use \League\Route\Strategy\UriStrategy;
use \League\Route\RouteCollection;
use \Mickeyhead7\Api\Container\ContainerTrait;
use \Mickeyhead7\Api\ConnectionManager\Database;
use \Mickeyhead7\Api\Response\NotFound as ResponseNotFound;

class App
{

    /**
     * Use the container trait for access to a container
     */
    use ContainerTrait;

    /**
     * Current request object
     *
     * @var
     */
    protected $request;

    /**
     * Path to the application .env file
     *
     * @var
     */
    private $env_path;

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
            ->loadRequest()
            ->parseEnv()
            ->setEnvironment()
            ->makeConnections()
            ->setRoutes();

        return $this;
    }

    /**
     * Loads the global request object
     *
     * @return $this
     */
    public function loadRequest()
    {
        $this->request = Request::createFromGlobals();

        return $this;
    }

    /**
     * Enable the setting of the path to the .env file
     *
     * @param $path
     * @return $this
     */
    public function setEnvPath($path)
    {
        $this->env_path = $path;

        return $this;
    }

    /**
     * Loads environment settings
     *
     * @return $this
     */
    public function parseEnv()
    {
        // Test for passed routes.php and app root fallback
        $app_dir = $this->request->server->get('DOCUMENT_ROOT') . '/../';
        if (!is_file($this->env_path . '/routes.php') && is_file($app_dir . '/.env')) {
            $this->env_path = $app_dir;
        }

        // Load the .env file
        \Dotenv::load($this->env_path);

        return $this;
    }

    /**
     * Set's the environment
     *
     * @return $this
     */
    public function setEnvironment()
    {
        // Always enable error reporting
        error_reporting(E_ALL);

        switch (getenv('ENVIRONMENT'))
        {

            case 'development' :
                ini_set('display_errors', 1);
                break;

            case 'production' :
                ini_set('display_errors', 0);
                break;

        }

        return $this;
    }

    /**
     * Enable the setting of the path to the routes file
     *
     * @param $path
     * @return $this
     */
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
        // Get the current route path
        $path = $this->request->getPathInfo();

        if ($path != '/') {
            $path = rtrim($this->request->getPathInfo(), '/');
        }

        // Test for passed routes.php and app root fallback
        $app_dir = $this->request->server->get('DOCUMENT_ROOT') . '/../routes';
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
            $response = $dispatcher->dispatch($this->request->getMethod(), $path);
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