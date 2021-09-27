<?php

namespace Views;

use Singletone\Singleton;

class View extends Singleton {
    public static function render($template, $vars = [])
    {
        extract($vars);
        require_once "Views/".$template.'.php';
    }
}