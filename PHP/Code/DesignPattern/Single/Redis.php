<?php

namespace App\Single;

class Redis
{
    private function __construct()
    {
        echo "Connect to redis...\n";
    }

    private function __clone()
    {
    }

    private static $instance = null;

    public static function getRedis()
    {
        if (static::$instance == null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function showMsg()
    {
        echo "Hello World\n";
    }
}
