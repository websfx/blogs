<?php

namespace App\Builder;

interface Builder
{
    public function createCpu(string $cpu);

    public function createHdd(string $hdd);

    public function createMb(string $mb);

    public function createMem(string $mem);

    public function createComputer();
}
