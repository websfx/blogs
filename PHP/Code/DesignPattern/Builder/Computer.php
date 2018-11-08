<?php

namespace App\Builder;

class Computer
{
    private $cpu;
    private $hdd;
    private $mb;
    private $mem;

    /**
     * @return mixed
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * @param mixed $cpu
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;
    }

    /**
     * @return mixed
     */
    public function getHdd()
    {
        return $this->hdd;
    }

    /**
     * @param mixed $hdd
     */
    public function setHdd($hdd)
    {
        $this->hdd = $hdd;
    }

    /**
     * @return mixed
     */
    public function getMb()
    {
        return $this->mb;
    }

    /**
     * @param mixed $mb
     */
    public function setMb($mb)
    {
        $this->mb = $mb;
    }

    /**
     * @return mixed
     */
    public function getMem()
    {
        return $this->mem;
    }

    /**
     * @param mixed $mem
     */
    public function setMem($mem)
    {
        $this->mem = $mem;
    }

    public function __toString()
    {
        return sprintf("This computer: cpu is %s, hdd is %s, mb is %s, mem is %s", $this->cpu, $this->hdd, $this->mb, $this->mem);
    }
}
