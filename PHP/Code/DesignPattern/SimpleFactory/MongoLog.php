<?php

namespace App\SimpleFactory;

class MongoLog implements Log
{
    public function log(string $param)
    {
        echo "Log $param to Mongo\n";
    }
}
