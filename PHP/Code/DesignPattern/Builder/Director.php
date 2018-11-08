<?php

namespace App\Builder;

class Director
{
    private $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function buildCpu(string $cpu)
    {
        $this->builder->createCpu($cpu);
        return $this;
    }

    public function buildHdd(string $hdd)
    {
        $this->builder->createHdd($hdd);
        return $this;
    }

    public function buildMb(string $mb)
    {
        $this->builder->createMb($mb);
        return $this;
    }

    public function buildMem(string $mem)
    {
        $this->builder->createMem($mem);
        return $this;
    }

    public function createComputer(): Computer
    {
        return $this->builder->createComputer();
    }
}
