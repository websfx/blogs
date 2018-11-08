<?php

namespace App\FactoryMethod;

class MongoLog implements Log
{
    public function log(string $param)
    {
        echo "Log $param to Mongo\n";
    }
}
