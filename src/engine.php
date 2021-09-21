<?php

/*
Не стал заморачиваться с autoload на данном этапе
*/
require_once "router.php";

$router = Router::getInstance();
$router->run();