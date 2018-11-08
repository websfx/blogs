<?php

namespace App\FactoryMethod;

class MongoLogFactory implements LogFactory
{
    public function getLog()
    {
        return new MongoLog();
    }
}
