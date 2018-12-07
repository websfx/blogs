<?php

namespace App\Decorator;

class EgeDecorator extends PancakeDecorator
{
    public function __construct(IPancake $pancake)
    {
        parent::__construct($pancake);
    }

    public function cook()
    {
        echo "加了一个鸡蛋...\n";
        parent::cook();
    }

    public function price()
    {
        return 1;
    }
}
