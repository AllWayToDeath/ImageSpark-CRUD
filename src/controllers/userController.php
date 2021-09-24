<?php

require_once "functions.php";
require_once "controller.php";
require_once "models/userModel.php";

class UserController extends Controller
{
    public function print()
    {
        $userList = UserModel::getAll();
        View::render("users", ["userList" => $userList]);
    }

    protected static function create()
    {        
        $vararr = array(
            "title"           => "Create"
            ,"buttonSaveName" => "Create"
            ,"userID"         => 1 + UserModel::getLastJsonID()
            ,"checked"        => null
            ,"userData"       => null
        );

        return $vararr;
    }

    protected static function edit($userID)
    {
        $userModel = new UserModel();
        $userData = $userModel->loadAndGetData($userID);

        $vararr = array(
            "title"           => "Edit"
            ,"buttonSaveName" => "Save"
            ,"userID"         => $userID
            ,"checked"        => $userData["active"]
            ,"userData"       => $userData
        );

        return $vararr;
    }

    protected static function trySave($userID)
    {
        $userData = [
            "login"   => Router::getVar("editUserLogin")
            ,"fname"  => Router::getVar("editUserFname")
            ,"lname"  => Router::getVar("editUserLname")
            ,"bday"   => [
                "day"    => Router::getVar("editUserBdayD")
                ,"month" => Router::getVar("editUserBdayM")
                ,"year"  => Router::getVar("editUserBdayY")
                ]
            ,"active" => getActiveStatus(Router::getVar("editUserActive"))
            ,"id" => $userID
        ];

        //Validation
        $errors = static::validateUserData($userData);

        if(empty($errors))
        {
            $userModel = new UserModel();
            $userModel->setData($userData);
            $userModel->save();
        }

        return $errors;
    }

    public function editOrCreate()
    {
        $errors = array();

        if(count($_POST) > 0)
        {
            $id = Router::getVar("editUserSubmit");
            $errors = static::trySave($id);

            if(count($errors) == 0)
            {
                header("location: /users");
                return;
            }
        }
        $vararr = array(); 
        
        if(isset($_GET["id"]))
        {
            $vararr = static::edit($_GET["id"]);
        }
        else
        {
            $vararr = static::create();
        }
        $vararr["errors"] = $errors;

        View::render("editUser", $vararr);
    }

    public function delete()
    {
        UserModel::deleteByID($_GET["id"]);
        header("location: /users");
    }

    protected static function validateUserData($userData)
    {
        extract($userData);
        $errors = array();   
        
        $erLogin = static::validateLogin($login);
        $erFName = static::validateName($fname, "First");
        $erLName = static::validateName($lname, "Last");
        $erBDay = static::validateDate($bday);

        $errors = array_merge(
            $erLogin, 
            $erFName, 
            $erLName, 
            $erBDay
        );
        return $errors;
    }

    protected static function validateLogin($login)
    {
        $errors = array();

        //↓↓↓ No ARAB style! ↓↓↓
        if($login == null)
        {
            $errors []= "Login is empty";
        }

        //add other logic here ...

        return $errors;
    }

    protected static function validateName($name, $prefix = "")
    {
        $errors = array();
        $postfix = ($prefix == "") ?
             "Name": "$prefix name";

        if($name == null)
        {
            $errors []= "$postfix is empty";
        }
        if(! preg_match("/^[a-zA-z]*$/", $name))
        {
            $errors []= "$postfix contain a wrong symbol";
        }

        //add other logic here ...

        return $errors;
    }
}