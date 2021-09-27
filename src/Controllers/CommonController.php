<?php

namespace Controllers;

use Controllers\Controller;
use Views\View;

class CommonController extends Controller
{
    public function menu()
    {
        View::render("menu");
    }
    public function notFound()
    {
        View::render("notFound");
    }
}