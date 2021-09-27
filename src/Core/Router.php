<?php

namespace Core;

use Controllers\CommonController;
use Controllers\UserController;
use Controllers\DocumentController;
use Singleton\Singleton;

class Router extends Singleton
{
    public function run()
    {
        $path = $this->getPath();
        $controller = null;

        $controllerType = "CommonController";
        $methodName     = "notFound";

        foreach($this->routes as $outerWay => $innerWay)
        {
            if($outerWay == $path)
            {
                $controllerType = (string)$innerWay["className"];
                $methodName     = (string)$innerWay["method"];

                break;
            }
        }

        $controller = new $controllerType;
        $controller->$methodName();
    }

    public static function getVar($name, $default = null)
    {
        if(array_key_exists($name, $_GET))
        {
            return $_GET[$name];
        }
        if(array_key_exists($name, $_POST))
        {
            return $_POST[$name];
        }
    }

    protected function getPath()
    {
        $path = $_SERVER['REQUEST_URI'];
        $idQ = strpos($path, "?");
        if($idQ > 0)
            $path = substr($path, 0, $idQ);

        return $path;
    }

    protected $routes = array(
        "/menu"             => [
                                "className" => CommonController::class,
                                "method" => "menu"
                            ],
        "/users"           => [
                                "className" => UserController::class,
                                "method" => "print"
                            ],
        "/edit/user"       => [
                                "className" => UserController::class,
                                "method" => "editOrCreate"
                            ],
        "/delete/user"     => [
                                "className" => UserController::class,
                                "method" => "delete"
                            ],
        "/documents"       => [
                                "className" => DocumentController::class,
                                "method" => "print"
                            ],
        "/edit/document"   => [
                                "className" => DocumentController::class,
                                "method" => "editOrCreate"
                            ],
        "/delete/document" => [
                                "className" => DocumentController::class,
                                "method" => "delete"
                            ]
    );
}