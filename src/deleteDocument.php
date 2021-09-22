<?php
require_once "save.php";
$fileName = $_GET["id"].".json";
$successDelete = unlink(SAVEPATHDOCUMENT.$fileName);

if($successDelete)
{
    header("Location: /documents");
}