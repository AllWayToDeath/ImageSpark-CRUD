<?php

require_once "singleton.php";

class Router extends Singleton
{
    protected $routes = array(
        "/menu"             => "menu.php"
        ,"/users"           => "users.php"
        ,"/documents"       => "documents.php"
        ,"/edit/user"       => "editUser.php"
        ,"/edit/document"   => "editDocument.php"
        ,"/delete/document" => "deleteDocument.php"
        ,"/delete/user"     => "deleteUser.php"
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
            require_once "notFound.php";
        }

    }

    public function getVar($name, $default = null)
    {

    }
}