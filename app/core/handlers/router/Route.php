<?php

namespace App\Core\Handlers\Router;

use Closure;

class Route
{
    public Closure $callback;
    public array $pathParams = [];
    public array $before = [];
    public array $after = [];

    public function __construct(Closure $callback, array $pathParams)
    {
        $this->callback = $callback;
        $this->pathParams = $pathParams;
    }

    /**
     * Returns the callback
     *
     * @return Closure
     */
    public function getCallback(): Closure
    {
        return $this->callback;
    }
}
