<?php

require_once "routes.php";

//var_dump("Engine/Get $_GET");
//die();
function getPath()
{
    $tmpArr = array();
    parse_str($_SERVER['REQUEST_URI'], $tmpArr);
    $path = array_key_first($tmpArr);
    //unset($tmpArr);

    //delete ?
    $idQ = strpos($path, "?");
    if($idQ > 0)
        $path = substr($path, 0, $idQ);
    
    return $path;
}

//parse_str($_SERVER['QUERY_STRING'], $_GET);

$path = getPath();
//var_dump("path = ".$path);
$notFound = true;

foreach(getRoutes() as $outerWay => $innerWay)
{
    if($outerWay == $path)
    {
        $notFound = false;
        require_once $innerWay;
    }
}
/*
$arguments = array();

$path = explode("&", $_SERVER['QUERY_STRING'])[0];

$notFound = true;
foreach($routes as $outerWay => $innerWay)
{
    //parse_str($_SERVER['QUERY_STRING'], $_GET);
    if($outerWay == $path)
    {
        $notFound = false;
        
        if(1 < count($_GET))
        {
            $argsStr = "?";
            foreach($_GET as $key => $value)
            {
                $argsStr .= "$key=$value";
            }
        }
        var_dump($$_GET);
        require_once $innerWay;
    }
}
*/
if($notFound)
{
    require_once "notFound.php";
}
