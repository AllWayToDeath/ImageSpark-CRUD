<?php

require_once "routes.php";

//$path = stristr($_SERVER['REQUEST_URI'], '?', true);
function getPath()
{
    $tmpArr = array();
    parse_str($_SERVER['REQUEST_URI'], $tmpArr);
    $path = array_key_first($tmpArr);
    unset($tmpArr);

    //delete ?
    $idQ = strpos($path, "?");
    if($idQ > 0)
        $path = substr($path, 0, $idQ);
    
    return $path;
}

$path = getPath();
$notFound = true;

foreach(getRoutes() as $outerWay => $innerWay)
{
    if($outerWay == $path)
    {
        $notFound = false;
        require_once $innerWay;
    }
}
if($notFound)
{
    require_once "notFound.php";
}
