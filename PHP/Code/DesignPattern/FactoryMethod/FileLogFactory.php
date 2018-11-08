<?php

namespace App\FactoryMethod;

class FileLogFactory implements LogFactory
{
    public function getLog()
    {
        return new FileLog();
    }
}
