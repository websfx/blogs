<?php

namespace Chain;

use Closure;

class LogHandler implements Handler
{
    public function execute(Closure $next)
    {
        echo "Before Log!\n";
        $next();
        echo "After Log!\n";
    }
}
