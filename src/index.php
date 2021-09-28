<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("db", "root", "root", "myapp");


/* Запросы SELECT, возвращают набор результатов */
$result = $mysqli->query("SELECT * FROM users");
printf("Запрос SELECT вернул %d строк.\n", $result->num_rows);

require_once "vendor/autoload.php";

use Core\Router;


$router = Router::getInstance();
$router->run();