<?php

namespace Chain;

require 'Client.php';
require 'Handler.php';
require 'LogHandler.php';
require 'CheckAgeHandler.php';

$client = new Client();

$client->addHandler(new LogHandler())
    ->addHandler(new CheckAgeHandler());

$client->handler();