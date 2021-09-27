<?php

namespace Controllers;

use Core\Router;
use Controllers\DataController;
use Models\UserModel;
use Views\View;
use Validator\Validator;

class UserController extends DataController
{
    protected $modelClass = UserModel::class;

    public function print()
    {
        $userList = UserModel::getAll();
        View::render("users", ["userList" => $userList]);
    }

    protected static function create()
    {        
        $vararr = array(
            "title"           => "Create",
            "buttonSaveName" => "Create",
            "userID"         => 1 + UserModel::getLastJsonID(),
            "checked"        => null,
            "userData"       => null
        );

        return $vararr;
    }

    protected static function edit($userID)
    {
        $userModel = new UserModel();
        $userData = $userModel->loadAndGetData($userID);

        $vararr = array(
            "title"           => "Edit",
            "buttonSaveName" => "Save",
            "userID"         => $userID,
            "checked"        => $userData["active"],
            "userData"       => $userData
        );

        return $vararr;
    }

    protected static function trySave($userID)
    {
        $result = array();

        $userData = [
            "login"   => Router::getVar("editUserLogin"),
            "fname"  => Router::getVar("editUserFname"),
            "lname"  => Router::getVar("editUserLname"),
            "bday"   => [
                "day"    => Router::getVar("editUserBdayD"),
                "month" => Router::getVar("editUserBdayM"),
                "year"  => Router::getVar("editUserBdayY")
            ],
            "active" => UserModel::getActiveStatus(Router::getVar("editUserActive")),
            "id" => $userID
        ];

        //Validation
        $errors = Validator::validateUserData($userData);

        if(count($errors) == 0)
        {
            $userModel = new UserModel();
            $userModel->setData($userData);
            $userModel->save();
        }

        $result["data"] = $userData;
        $result["errors"] = $errors;

        return $result;
    }

    public function editOrCreate()
    {
        $result = parent::baseEditOrCreate("users", "editUserSubmit");

        $vararr = $result["vararr"];
        $vararr["errors"] = $result["errors"];

        if(isset($result["data"]))
        {
            $vararr["userData"] = $result["data"];
        }

        View::render("editUser", $vararr);
    }

    public function delete()
    {
        UserModel::deleteByID($_GET["id"]);
        header("location: /users");
    }
}