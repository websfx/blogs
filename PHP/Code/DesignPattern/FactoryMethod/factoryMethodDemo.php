<?php

require "../include.php";

$fileLogFactory = new \App\FactoryMethod\FileLogFactory();
$fileLog = $fileLogFactory->getLog();
$fileLog->log("something");
