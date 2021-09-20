<?php

$routes = array(
    "/menu"             => "menu.php"
    ,"/users"           => "users.php"
    ,"/documents"       => "documents.php"
    ,"/edit/user"       => "editUser.php"
    ,"/edit/Document"   => "editDocument.php"
);
$tmpArr = array();
parse_str($_SERVER['QUERY_STRING'], $_GET);
parse_str($_SERVER['QUERY_STRING'], $tmpArr);
$path = array_key_first($tmpArr);

var_dump($path);

foreach($routes as $outerWay => $innerWay)
{
    //parse_str($_SERVER['QUERY_STRING'], $_GET);
    if($outerWay == $path)
    {
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
if($notFound)
{
    //require_once "notFound.php";
}
*/