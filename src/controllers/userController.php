<?php

require_once "controller.php";
require_once "../models/userModel.php";

class UserController extends Controller
{
    public function print()
    {
        $userList = UserModel::getAll();

        foreach($userList as $user)
        {
            print_r($user);
            echo "\n";
        }

        //Работа с View
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}