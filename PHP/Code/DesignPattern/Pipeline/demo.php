<?php

namespace Chain;

require 'Client.php';
require 'Middleware.php';
require 'LogMiddleware.php';
require 'AuthMiddleware.php';

$client = new Client();

$client->addMiddleware(new LogMiddleware())
    ->addMiddleware(new AuthMiddleware());

$client->handler();