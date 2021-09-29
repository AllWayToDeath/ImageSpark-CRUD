<?php
/*
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("db", "root", "root", "myapp");


//Запросы SELECT, возвращают набор результатов
$result = $mysqli->query("SELECT * FROM users");
printf("Запрос SELECT вернул %d строк.\n", $result->num_rows);
*/

require_once "vendor/autoload.php";


use Models\DBModel;
use Models\UserModel;
use Models\DocumentModel;

/*==========|Начало отладочного кода|==========*/

// $model = new DBModel();
// $list = $model->list();
//var_dump($list);


$uModel = new UserModel();
/*
$uModel->create([
    "login" => "Car",
    "first_name" => "Lightning",
    "last_name" => "MacQuin",
    "bday" => "2000-04-04",
    "active" => "1" 
]);
*/
/*
$uModel->update(3, [
    "login" => "Car",
    "fname" => "Lightning",
    "lname" => "MacQuin",
    "bday" => "2006-06-06",
    "active" => "0" 
]);
*/
/*
$uModel->create([
    "login" => "Car",
    "first_name" => "Lightning",
    "last_name" => "MacQuin",
    "bday" => "2000-04-04",
    "active" => "0" 
]);
*/
//$uModel->delete(5);

$dModel = new DocumentModel();
/*
$dModel->create([
    "organisation" => "DriveMegaSega",
    "counteragent" => "Sega",
    "dateofcontract" => array(
        "start" => "1951-04-01",
        "finish" => "2021-09-29"
    ),
    "objectofcontract" => "Game station",
    "currency" => "₽",
    "costofcontract" => "700",
    "requisites" => array(
        "address" => "Germany",
        "inn" => "123456789012",
        "chacc" => "CompanyGerSeGa"
    )
]);
*/

/*
$dModel->update(2, [
    "organisation" => "Nintendo Switch",
    "counteragent" => "Nintendo",
    "dateofcontract" => array(
        "start" => "1900-04-01",
        "finish" => "2021-09-29"
    ),
    "objectofcontract" => "Game station",
    "currency" => "₽",
    "costofcontract" => "800",
    "requisites" => array(
        "address" => "SomeWhere",
        "inn" => "123456789012",
        "chacc" => "CompanyNineTenDo"
    )
]);
*/

$dModel->delete(3);

return;

/*==========|Конец отладочного кода|==========*/

use Core\Router;

//** @var Router */
$router = Router::getInstance();
$router->run();