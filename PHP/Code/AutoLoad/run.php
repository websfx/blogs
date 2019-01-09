<?php
require "vendor/autoload.php";
require "bootstrap.php";

$jwt = new \App\Jwt();

//$token = $jwt->genToken(10);
//
//print_r($token);

$token = "eyJhbGciOiJzaGEyNTYiLCJ0eXAiOiJKV1QifQ." .
    "eyJpc3MiOiJhZG1pbiIsImV4cCI6MTU0NzAwOTg0NCwic3ViIjoidGVzdCIsImF1ZCI6ImV2ZXJ5IiwibmJmIjoxNTQ3MDA5MjQ0LCJpYXQiOjE1NDcwMDkyNDQsImp0aSI6MTAwMDEsInVpZCI6MTB9." .
    "3f80852da72144bf30dfc021c04e1750ab959b19e9a2cce8c9495baac42ce816";

$uid = $jwt->verifyToken($token);

print_r($uid);
