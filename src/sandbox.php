<?php

class TestClass
{
    public function sayHi()
    {
        echo "Hi!\n";
    }
}

$classname = "TestClass";
$functionname = "sayHi";

$instance = new $classname;

$instance->$functionname();


require_once "controllers/userController.php";

$uc = new UserController;
$uc->print();