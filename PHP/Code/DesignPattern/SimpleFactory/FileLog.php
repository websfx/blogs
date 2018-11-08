<?php

namespace App\SimpleFactory;

class FileLog implements Log
{
    public function log(string $param)
    {
        echo "Log $param to File\n";
    }
}
