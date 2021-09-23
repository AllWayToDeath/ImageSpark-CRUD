<?php

require_once "controller.php";
require_once "models/userModel.php";
require_once "views/view.php";

class UserController extends Controller
{
    public function print()
    {
        $userList = UserModel::getAll();
        //var_dump("UC UL = ");
        //var_dump($userList);
        View::render("users", ["userList" => $userList]);
    }

    public function edit()
    {
        $editableUser = new UserModel;
        $editableUser->loadDataFromJSON($_GET["id"]);

        /*
        Вызов getVar где-то здесь, но не позже
        */

        //Или нужно компановать все данные в отдельный массив?
        View::render("editUser", $_GET);

        /*
        require_once "save.php";

        $title = "Create";
        $buttonSaveName = "Create";
        $userID = null;

        if(isset($_GET["id"]))
        {
            $userData = loadUser($_GET["id"]);
            $checked = getCheckedStatus($userData["active"]);
            $title = "Edit";
            $buttonSaveName = "Save";
            $userID = $_GET["id"];
        }
        */


    }

    public function delete()
    {
        UserModel::deleteByID($_GET["id"]);
    }
}

/*
DocEd

require_once "save.php";

$title = "Create";
$buttonSaveName = "Create";
$documentID = null;

if(isset($_GET["id"]))
{
    $documentData = loadDocument($_GET["id"]);
    $title = "Edit";
    $buttonSaveName = "Save";
    $documentID = $_GET["id"];
}
*/