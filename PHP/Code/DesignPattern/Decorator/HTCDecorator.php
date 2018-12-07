<?php

namespace App\Decorator;

class HTCDecorator extends PancakeDecorator
{
    public function __construct(IPancake $pancake)
    {
        parent::__construct($pancake);
    }

    public function cook()
    {
        echo "加了一根火腿肠...\n";
        parent::cook();
    }

    public function price()
    {
        return 1.5;
    }
}
