<?php

namespace Chain;

class Client
{
    protected $middlewares = [];

    public function addMiddleware(Middleware $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function getClosure()
    {
        return function ($current, $next) {
            return function () use ($current, $next) {
                return (new $next)->execute($current);
            };
        };
    }

    public function defaultHandler()
    {
        return function () {
            echo "开始处理!\n";
        };
    }

    public function handler()
    {
        call_user_func(array_reduce($this->middlewares, $this->getClosure(), $this->defaultHandler()));
    }
}
