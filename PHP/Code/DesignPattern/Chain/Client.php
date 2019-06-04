<?php

namespace Chain;

class Client
{
    protected $handlers = [];

    public function addHandler(Handler $handler)
    {
        $this->handlers[] = $handler;

        return $this;
    }

    public function getSlice()
    {
        return function ($stack, $handler) {
            return function () use ($stack, $handler) {
                return (new $handler)->execute($stack);
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
        call_user_func(array_reduce($this->handlers, $this->getSlice(), $this->defaultHandler()));
    }
}
