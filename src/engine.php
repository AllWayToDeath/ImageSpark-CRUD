<?php
require_once "vendor/autoload.php";

//require_once "Router.php";
use src\Router;

$router = Router::getInstance();
$router->run();