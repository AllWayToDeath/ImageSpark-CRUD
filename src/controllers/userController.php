<?php

require_once "controller.php";
require_once "../models/userModel.php";

class UserController extends Controller
{
    public function print()
    {
        $userList = UserModel::getAll();

        //Работа с View
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}