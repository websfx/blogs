<?php

namespace Chain;

use Closure;

interface Middleware
{
    public function execute(Closure $next);
}
