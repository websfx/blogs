<?php

namespace App\Decorator;

class Pancake implements IPancake
{
    public function price()
    {
        return 5;
    }

    public function cook()
    {
        echo "制作煎饼...\n";
    }
}
