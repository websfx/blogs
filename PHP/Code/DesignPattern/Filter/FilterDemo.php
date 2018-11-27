<?php
include "../include.php";

$users = [];

$users[] = new \App\Filter\User(1, "1", 25, "男");
$users[] = new \App\Filter\User(2, "2", 35, "男");
$users[] = new \App\Filter\User(3, "3", 27, "女");
$users[] = new \App\Filter\User(4, "4", 21, "男");
$users[] = new \App\Filter\User(5, "5", 24, "女");

$ageFilter = new \App\Filter\AgeFilter();
$result    = $ageFilter->filter($users);


$maleFilter = new \App\Filter\MaleFilter();
$result     = $maleFilter->filter($result);

var_dump($result);
