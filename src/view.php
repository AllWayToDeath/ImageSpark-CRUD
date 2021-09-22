<?php

require_once "singleton.php";

class View extends Singleton
{
    public function render($template, $vars = [])
    {
        $var['title'] = 'Заголовок';
        extract($vars);

        echo $title;
        require_once "views/".$template.'.tpl';
    }
}