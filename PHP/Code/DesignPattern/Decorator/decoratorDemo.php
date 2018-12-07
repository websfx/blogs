<?php
require_once "../include.php";

$cake = new \App\Decorator\Pancake();
$cake->cook();

echo "-----------------------------------------\n";

$egeCake = new \App\Decorator\EgeDecorator($cake);
$egeCake->cook();

echo "-----------------------------------------\n";

$htcCake = new \App\Decorator\HTCDecorator($cake);
$htcCake->cook();

echo "-----------------------------------------\n";

$htcCake = new \App\Decorator\HTCDecorator($egeCake);
$htcCake->cook();
