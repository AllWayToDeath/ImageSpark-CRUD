<?php
require_once "engine.php";
header("Location: /menu");

if(false)
{
    http_response_code(404);
    echo '404';
    die();
}

/*
$_SERVER[REQUEST_URI]=string(27) "/index.php?/menu/88pp&id=00"
$_SERVER[QUERY_STRING]=string(16) "/menu/88pp&id=00"
$_GET=array(2) { ["/menu/88pp"]=> string(0) "" ["id"]=> string(2) "00" }
404
*/
/*
echo '$_SERVER[REQUEST_URI]=';
var_dump($_SERVER['REQUEST_URI']);
echo '<br>';

// var_dump($_SERVER);
echo '$_SERVER[QUERY_STRING]=';
var_dump($_SERVER['QUERY_STRING']);
echo '<br>';

echo '$_GET=';
var_dump($_GET);
echo '<br>';
*/