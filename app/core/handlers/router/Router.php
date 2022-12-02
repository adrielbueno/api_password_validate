<?php

namespace App\Core\Handlers\Router;

use App\Core\Handlers\Request\RequestHandler;
use App\Core\Utils\Str;
use Closure;

class Router
{
    private static array $routes;
    private static ?self $instance = null;
    private static RequestHandler $request;

    private function __construct()
    {
    }

    /**
     * Returns an instance of Router
     *
     * @return Router
     */
    public static function getInstance(): Router
    {
        self::$instance ??= new Router();
        self::$request = RequestHandler::getInstance();

        return self::$instance;
    }

    /**
     * Returns the routes
     *
     * @return array
     */
    public function getRoutes(bool $withPathParams): array
    {
        return self::$routes[self::$request->getMethod()][$withPathParams] ?? [];
    }

    /**
     * Defines the route verb
     * @param string $url Endpoint to be added to system GET routes
     * @param Closure $callback
     * @return Route
     */
    public function get(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'GET');
    }

    /**
     * Defines the route verb
     * @param string $url Endpoint to be added to system POST routes
     * @param Closure $callback
     * @return Route
     */
    public function post(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'POST');
    }

    /**
     * Defines the route verb
     * @param string $url Endpoint to be added to system PUT routes
     * @param Closure $callback
     * @return Route
     */
    public function put(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'PUT');
    }

    /**
     * Defines the route verb
     * @param string $url Endpoint to be added to system DELETE routes
     * @param Closure $callback
     * @return Route
     */
    public function delete(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'DELETE');
    }

    /**
     * Defines the route verb
     * @param string $url Endpoint to be added to system PATCH routes
     * @param Closure $callback
     * @return Route
     */
    public function patch(string $url, Closure $callback): Route
    {
        return $this->addRoute($url, $callback, 'PATCH');
    }

    /**
     * Defines the route verb
     * @param string $url Endpoint to be added to system ANY routes
     * @param Closure $callback
     * @return Route
     */
    public function any($url, $callback): Route
    {
        switch (self::$request->getMethod()) {
            case 'GET':
                return $this->get($url, $callback);
            case 'POST':
                return $this->post($url, $callback);
            case 'PUT':
                return $this->put($url, $callback);
            case 'DELETE':
                return $this->delete($url, $callback);
            case 'PATCH':
                return $this->patch($url, $callback);
        }
    }

    /**
     * Register routes in the system
     *
     * @param string $url
     * @param Closure $callback
     * @param string $method
     *
     * @return Route
     */
    private function addRoute(string $url, Closure $callback, string $method): Route
    {
        $url = Str::setUrlPattern($url);

        $pathParams = self::$request->getPathParams($url);
        return self::$routes[$method][$pathParams !== []][$url] = new Route($callback, $pathParams);
    }
}
