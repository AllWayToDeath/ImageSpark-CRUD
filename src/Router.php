<?php
namespace src;
//require_once "Singleton.php";

use src\Singleton;

class Router extends Singleton
{
    protected $routes = array(
        "/menu"             => "Menu.php"
        ,"/users"           => "Users.php"
        ,"/documents"       => "Documents.php"
        ,"/edit/user"       => "EditUser.php"
        ,"/edit/document"   => "EditDocument.php"
        ,"/delete/document" => "DeleteDocument.php"
        ,"/delete/user"     => "DeleteUser.php"
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

        foreach($this->routes as $outerWay => $innerWay)
        {
            if($outerWay == $path)
            {
                $notFound = false;
                require_once $innerWay;
            }
        }
        if($notFound)
        {
            require_once "NotFound.php";
        }

    }

    public function getVar($name, $default = null)
    {

    }
}