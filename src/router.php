<?php

require_once "singleton.php";
require_once "controllers/commonController.php";
require_once "controllers/userController.php";
require_once "controllers/documentController.php";

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
                                "className" => "CommonController",
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
}