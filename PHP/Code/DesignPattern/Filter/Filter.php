<?php

namespace App\Filter;

interface Filter
{
    public function filter(array $users): array;
}
