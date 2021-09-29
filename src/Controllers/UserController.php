<?php

namespace Controllers;

use Core\Router;
use Core\View;
use Controllers\DataController;
use Models\UserModel;
use Validator\Validator;

class UserController extends DataController
{
    protected $modelClass = UserModel::class;

    public function print()
    {
        $userList = UserModel::getAll();
        //var_dump($userList);


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
            if($userID == null)
            {
                UserModel::create($userData);
            }
            else
            {
                UserModel::update($userID, $userData);
            }

            // $userModel = new UserModel();
            // $userModel->setData($userData);
            // $userModel->save();
        }

        $result["data"] = $userData;
        $result["errors"] = $errors;

        return $result;
    }

    public function editOrCreate()
    {

        if(isset($_GET["id"]))
        {   
            $userID = $_GET["id"];
            $userData = UserModel::getByID($userID);
            // var_dump($userData);
            // die("I am DIE!");

            $vararr = array(
                "title"           => "Edit",
                "buttonSaveName" => "Save",
                "userID"         => $userID,
                "checked"        => $userData["active"],
                "userData"       => $userData
            );

            //$result["vararr"] = static::edit($_GET["id"]);
        }
        else
        {
            $vararr = array(
                "title"           => "Create",
                "buttonSaveName" => "Create",
                "checked"        => null,
                "userData"       => null
            );
            //$result["vararr"] = static::create();
        }

        if(count($_POST) > 0)
        {
            $id = Router::getVar("editUserSubmit");
            $temp = static::trySave($id);            
        
            if(count($temp["errors"]) == 0)
            {
                header("location: /users");
                return;
            }

            $vararr["data"] = $temp["data"];
            $vararr["errors"] = $temp["errors"];
            unset($temp);
        }

        if(isset($result["data"]))
        {
            $vararr["userData"] = $result["data"];
        }

        $output = View::render("editUser", $vararr);
        echo $output;
        
        //$vararr = $result["vararr"];
        //$vararr["errors"] = $result["errors"];

        /*
        $result = parent::baseEditOrCreate("users", "editUserSubmit");

        $vararr = $result["vararr"];
        $vararr["errors"] = $result["errors"];

        if(isset($result["data"]))
        {
            $vararr["userData"] = $result["data"];
        }

        $output = View::render("editUser", $vararr);
        echo $output;
        */
    }

    public function delete()
    {
        UserModel::delete($_GET["id"]);
        header("location: /users");
    }
}