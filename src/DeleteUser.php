<?php

namespace src;

require_once "Save.php";
$fileName = $_GET["id"].".json";
$successDelete = unlink(SAVEPATHUSER.$fileName);

if($successDelete)
{
    header("Location: /users");
}