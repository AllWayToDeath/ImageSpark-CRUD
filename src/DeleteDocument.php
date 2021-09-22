<?php

namespace src;

require_once "Save.php";
$fileName = $_GET["id"].".json";
$successDelete = unlink(SAVEPATHDOCUMENT.$fileName);

if($successDelete)
{
    header("Location: /documents");
}