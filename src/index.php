<?php
require_once "vendor/autoload.php";

use Core\Router;

$router = Router::getInstance();
$router->run();