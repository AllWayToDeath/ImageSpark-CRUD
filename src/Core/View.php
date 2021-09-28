<?php

namespace Core;


class View extends Singleton {
    public static function render($template, $vars = [])
    {
        extract($vars);
        ob_start();
        require_once "Views/".$template.'.php';
        return ob_get_clean();
    }
}