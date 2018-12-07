<?php

namespace App\Decorator;

abstract class PancakeDecorator implements IPancake
{
    private $pancake;

    public function __construct(IPancake $pancake)
    {
        $this->pancake = $pancake;
    }

    public function cook()
    {
        $this->pancake->cook();
    }
}
