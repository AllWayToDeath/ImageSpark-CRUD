<?php

require_once "controller.php";

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