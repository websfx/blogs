<?php

require "../include.php";

$builder = new \App\Builder\ConcreteBuilder();

$director = new \App\Builder\Director($builder);

$computer = $director->buildCpu("i7 8700k")
    ->buildHdd("Samsung 970")
    ->buildMb("Z370")
    ->buildMem("KingSD 16G")
    ->createComputer();

echo $computer;
