<?php

require_once "controller.php";
require_once "models/userModel.php";
require_once "views/view.php";

class UserController extends Controller
{
    public function print()
    {
        $userList = UserModel::getAll();
        View::render("users");
    }

    public function edit()
    {
        $editableUser = new UserModel;
        $editableUser->loadDataFromJSON($_GET["id"]);

        //Или нужно компановать все данные в отдельный массив?
        View::render("editUser", $_GET);
    }

    public function delete()
    {

    }
}