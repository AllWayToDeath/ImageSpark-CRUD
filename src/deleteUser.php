<?php
require_once "save.php";
$fileName = $_GET["id"].".json";
$successDelete = unlink(SAVEPATHUSER.$fileName);

if($successDelete)
{
    header("Location: /users");
}