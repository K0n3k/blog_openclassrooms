<?php

use App\Router\Router;

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$router = new Router($_SERVER, $_POST);
$router->reachRoute();