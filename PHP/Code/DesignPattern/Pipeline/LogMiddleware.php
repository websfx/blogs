<?php

namespace Chain;

use Closure;

class LogMiddleware implements Middleware
{
    public function execute(Closure $next)
    {
        echo "Before Log!\n";
        $next();
        echo "After Log!\n";
    }
}
