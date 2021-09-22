<?php

require_once "models/model.php";
require_once "views/view.php";

class Controller
{
    public function menu()
    {
        View::render("menu");
    }
}