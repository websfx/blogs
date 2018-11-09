<?php
require "vendor/autoload.php";

use App\ClassA;
use App\ClassB;

$a = new ClassA();

$b = new ClassB();

$c = new SomeClass();

var_dump($a);
var_dump($b);
var_dump($c);
