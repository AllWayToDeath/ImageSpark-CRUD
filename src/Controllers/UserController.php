<?php

namespace Controllers;

use Core\Router;
use Core\View;
use Controllers\DataController;
use Form\Builder;
use Form\UserForm;
use Models\UserModel;
use Validator\Validator;

class UserController extends DataController
{
    protected $modelClass = UserModel::class;

    public function print()
    {
        $userList = UserModel::getAll();
        //View::render("users", ["userList" => $userList]);
        $output = View::render("users", ["userList" => $userList]);
        echo $output;
    }

    protected static function create()
    {        
        $vararr = array(
            "title"           => "Create",
            "buttonSaveName" => "Create",
            "checked"        => null,
            "userData"       => null
        );

        return $vararr;
    }

    protected static function edit($userID)
    {
        $userData = UserModel::getByID($userID);

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

        $errors = Validator::validateUserData($userData);

        if(count($errors) == 0)
        {
            if($userID == null)
            {
                UserModel::create($userData);
            }
            else
            {
                UserModel::update($userID, $userData);
            }
        }
        
        $result["data"] = $userData;
        $result["errors"] = $errors;

        return $result;
    }

    public function editOrCreate()
    {
        //Create
        $form = new UserForm();
        $form->setModel(UserModel::class);
        //$form->loadFromModel(0);
        if($form->isValid())
        {
            $form->save($_POST);
            // redirect 
        }        
        $form->render();

        return;

        //Edit&Create
        $form = new UserForm();

        $form->setModel(UserModel::class);
        $form->loadFromModel("ID_2367376342");

        if ($form->isValid()) {
            $form->save();
            // redirect
        }
        $form->render();



        //

        /*
        $result = parent::baseEditOrCreate("users", "editUserSubmit");

        $vararr = $result["vararr"];
        $vararr["errors"] = $result["errors"];

        if(isset($result["data"]))
        {
            $vararr["userData"] = $result["data"];
        }

        $output = View::render("editUser", $vararr);
        echo $output;*/
    }

    public function delete()
    {
        UserModel::delete($_GET["id"]);
        header("location: /users");
    }
}