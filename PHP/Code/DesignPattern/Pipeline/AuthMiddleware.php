<?php

namespace Chain;

use Closure;

class AuthMiddleware implements Middleware
{
    public function execute(Closure $next)
    {
        echo "Before Check Auth!\n";
        $next();
        echo "After Check Auth!\n";
    }
}
