<?php
include "../include.php";

$char = new \App\Prototype\Character();
$char->name = "原型";
$char->id = 1;

var_dump($char);

$clone = clone $char;
$clone->id = 2;
$clone->name = "克隆之后的对象";
$clone->say();

var_dump($clone);
var_dump($char);
