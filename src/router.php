<?php

require_once "singleton.php";
require_once "controllers/controller.php";

/*

Два варианта реализации:

1.
Из роутера сделать таблицу с тремя значениями:
Внешний путь (/edit/user)
Внутренний путь (editUser.php)
Контроллер отвечающий за это (UserController)
- Контроллер делается все сразу

2.
В роутере меняем внутренний путь на контроллер
Передаем внешний путь в контроллер, который определяет дальнейшие действия
- Дважды парсить одну ти ту же строку

*/

class Router extends Singleton
{
    /*
    Здесь нужно заменить переходы на страницы на переходы на контроллеры
    Однако как передавать контроллерам план действий (удаление, редактирование..)
    И как тогда нам понимать это? Большой switch?
    */
    // protected $routes = array(
    //     "/menu"             => "menu.php"
    //     ,"/users"           => "users.php"
    //     ,"/edit/user"       => "editUser.php"
    //     ,"/delete/user"     => "deleteUser.php"
    //     ,"/documents"       => "documents.php"
    //     ,"/edit/document"   => "editDocument.php"
    //     ,"/delete/document" => "deleteDocument.php"
    // );

    protected $routes = array(
        "/menu"             => "Controller"
        ,"/users"           => "UserController"
        ,"/edit/user"       => "UserController"
        ,"/delete/user"     => "UserController"
        ,"/documents"       => "DocumentController"
        ,"/edit/document"   => "DocumentController"
        ,"/delete/document" => "DocumentController"
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

                //require_once $innerWay;
            }
        }
        if($notFound)
        {
            $controller = new Controller;
            //require_once "notFound.php";
        }
    }

    public function getVar($name, $default = null)
    {

    }
}