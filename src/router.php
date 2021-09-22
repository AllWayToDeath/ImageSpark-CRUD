<?php

require_once "singleton.php";
require_once "controllers/controller.php";
require_once "controllers/userController.php";

class Router extends Singleton
{
    protected $routes = array(
        "/menu"             => [
                                "className" => "Controller",
                                "method" => "menu"
                                ]
        ,"/users"           => [
                                "className" => "UserController",
                                "method" => "print"
                                ]
        ,"/edit/user"       => [
                                "className" => "UserController",
                                "method" => "edit"
                                ]
        ,"/delete/user"     => [
                                "className" => "UserController",
                                "method" => "delete"
                                ]
        ,"/documents"       => [
                                "className" => "DocumentController",
                                "method" => "print"
                                ]
        ,"/edit/document"   => [
                                "className" => "DocumentController",
                                "method" => "edit"
                                ]
        ,"/delete/document" => [
                                "className" => "DocumentController",
                                "method" => "delete"
                                ]
    );

    protected function getPath()
    {
        $path = $_SERVER['REQUEST_URI'];
        $idQ = strpos($path, "?");
        if($idQ > 0)
            $path = substr($path, 0, $idQ);

        return $path;
    }

    public function run()
    {
        //Выбор какой контроллер запустить и его запуск

        $path = $this->getPath();
        $notFound = true;
        $controller = null; 

        foreach($this->routes as $outerWay => $innerWay)
        {
            if($outerWay == $path)
            {
                $notFound = false;
                $func = (string)$innerWay["method"];

                $controller = new $innerWay["className"];
                $controller->$func();//В строку отдельную
            }
        }
        if($notFound)
        {
            //$controller = new Controller;
            //$controller->menu();
            require_once "notFound.php";
        }
    }

    public function getVar($name, $default = null)
    {
        return $_GET[$name];
    }
}