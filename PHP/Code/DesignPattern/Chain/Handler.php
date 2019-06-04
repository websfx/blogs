<?php

namespace Chain;

use Closure;

interface Handler
{
    public function execute(Closure $next);
}
