<?php

namespace Views;

use Singleton\Singleton;

class View extends Singleton {
    public static function render($template, $vars = [])
    {
        extract($vars);
        require_once "Views/".$template.'.php';
    }
}