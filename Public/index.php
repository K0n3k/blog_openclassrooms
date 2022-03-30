<?php

use App\Router\Router;

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$server["REQUEST_URI"] = $_SERVER["REQUEST_URI"];
$server["REQUEST_METHOD"] = $_SERVER["REQUEST_METHOD"];
if(!empty($_POST)) {
    $server["PARAMETERS"] = $_POST;
}
if(array_key_exists("PATH_INFO", $server)) {
    $this->server["PATH_INFO"] = $_SERVER["REQUEST_URI"];
}
$router = new Router($server);
$router->reachRoute();