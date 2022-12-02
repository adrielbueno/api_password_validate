<?php

namespace App\Core\Handlers\Router;

use App\Core\Handlers\Request\RequestHandler as Request;
use App\Core\Handlers\Response\ResponseHandler;
use App\Core\Utils\Str;

class Runner
{
    private string $url;
    private Router $router;
    private Request $request;
    private array $urlParts;

    public function __construct()
    {
        $this->request  = Request::getInstance();
        $this->router   = Router::getInstance();
        $this->url      = Str::setUrlPattern($this->request->getUrl());
        $this->urlParts = explode("/", $this->url);
    }

    /**
     * Run the project
     *
     * @return void
     */
    public function run(): void
    {
        $route  = $this->getRoute();
        $params = [];

        if ($route->pathParams !== []) {
            foreach (array_keys($route->pathParams) as $key) {
                $params[] = $this->urlParts[$key];
            }
        }

        $params[] = $this->request;

        echo call_user_func_array($route->getCallback(), $params);
    }

    /**
     * Returns the route
     *
     * @return Route
     */
    private function getRoute(): Route
    {
        $route = @$this->router->getRoutes(false)[$this->url];
        if ($route !== null) {
            return $route;
        }

        foreach (@$this->router->getRoutes(true) as $routeName => $route) {
            $routeParts = explode('/', $routeName);

            if (count($this->urlParts) === count($routeParts)) {
                $urlParts = $this->urlParts;

                foreach (array_keys($route->pathParams) as $key) {
                    unset($urlParts[$key]);
                    unset($routeParts[$key]);
                }

                if ($urlParts === $routeParts) {
                    return $route;
                }
            }
        }

        ResponseHandler::printJson(404, ["message" => "Algo inesperado aconteceu."]);
    }
}
