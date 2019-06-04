<?php

namespace Chain;

use Closure;

class CheckAgeHandler implements Handler
{
    public function execute(Closure $next)
    {
        echo "Before Check age!\n";
        $next();
        echo "After Check Age!\n";
    }
}
