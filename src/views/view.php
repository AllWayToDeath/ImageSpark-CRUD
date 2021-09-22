<?php

require_once "singleton.php";

class View extends Singleton
{
    public static function render($template, $vars = [])
    {
        extract($vars);
        require_once "views/".$template.'.php';
    }
}