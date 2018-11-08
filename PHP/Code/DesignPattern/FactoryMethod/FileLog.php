<?php

namespace App\FactoryMethod;

class FileLog implements Log
{
    public function log(string $param)
    {
        echo "Log $param to File\n";
    }
}
