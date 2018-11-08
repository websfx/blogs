<?php

namespace App\Builder;

class ConcreteBuilder implements Builder
{
    private $computer;

    public function __construct()
    {
        $this->computer = new Computer();
    }

    public function createCpu(string $cpu)
    {
        $this->computer->setCpu($cpu);
    }

    public function createHdd(string $hdd)
    {
        $this->computer->setHdd($hdd);
    }

    public function createMb(string $mb)
    {
        $this->computer->setMb($mb);
    }

    public function createMem(string $mem)
    {
        $this->computer->setMem($mem);
    }

    public function createComputer()
    {
        return $this->computer;
    }
}
