<?php

namespace Controllers;

use Controllers\Controller;
use Core\View;

class CommonController extends Controller
{
    public function menu()
    {
        //View::render("menu");
        $output = View::render("menu");
        echo $output;
    }
    public function notFound()
    {
        //View::render("notFound");
        $output = View::render("notFound");
        echo $output;
    }
}