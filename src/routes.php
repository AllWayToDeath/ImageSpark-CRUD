<?php

function getRoutes()
{
    /*
    Т.к. пути меняться не будут,
    рационально будет возвращать только константное значение.
    */
    //if(isset($routes)) return $routes;

    //"Типа" protected в функциональном стиле
    /*return function ()
    {
        $routes = array(
            "/menu"             => "menu.php"
            ,"/users"           => "users.php"
            ,"/documents"       => "documents.php"
            ,"/edit/user"       => "editUser.php"
            ,"/edit/Document"   => "editDocument.php"
        );
        return $routes;
    };*/

    //Оно же хоть как-то должно работать?
    return array(
        "/menu"             => "menu.php"
        ,"/users"           => "users.php"
        ,"/documents"       => "documents.php"
        ,"/edit/user"       => "editUser.php"//.(isset($_GET['id']) ? "?id=".$_GET['id']:"")
        ,"/edit/document"   => "editDocument.php"
    );
}