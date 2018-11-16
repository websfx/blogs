<?php

namespace App\Prototype;

class Character
{
    public $id;

    public $name;

    public function __construct()
    {
        echo "一些初始化工作\n";
    }

    public function say()
    {
        echo "Say something!\n";
    }
}
