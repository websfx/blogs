<?php

require "../include.php";

$factory = new \App\SimpleFactory\LogFactory();

$fileLog = $factory->getLogger($factory::FILE_LOG);
$fileLog->log("something");

$mongoLog = $factory->getLogger($factory::MONGO_LOG);
$mongoLog->log("something");
