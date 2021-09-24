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

    public function edit()
    {
        $title = "Create";
        $buttonSaveName = "Create";
        $userID = null;

        $userData = null;
        $dataIsLoaded = false;

        if(isset($_GET["id"]))
        {
            $title = "Edit";
            $buttonSaveName = "Save";
            $userID = $_GET["id"];

            $userModel = new UserModel();
            $dataIsLoaded = $userModel->loadDataFromJSON($_GET["id"]);
            
            if($dataIsLoaded)
            {
                $userData = $userModel->getData();
            }
            //In view
            $activeStatus = $userData["active"];
            $checked = getCheckedStatus($activeStatus);
        }
        $errors = array();

        //optimize
        if(count($_POST) > 0)
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
            ];

            //In model
            if(isset($_POST["editUserSubmit"]) && null != $_POST["editUserSubmit"])
            {
                $userData["id"] = $_POST["editUserSubmit"];
            }else{
                $userData["id"] = 1 + getLastJsonID(UserModel::SAVEPATH, UserModel::IDINFONAME);
            }

            //Validation
            $errors = static::validateUserData($userData);
            if(empty($errors))
            {
                $userModel = new UserModel();
                $userModel->setData($userData);
                $userModel->save();
                header("location: /users");
                return;
            }

            /*if(isComplete($userData))
            {
                
            }*/
        }

        $vararr = array(
            "title"           => $title
            ,"buttonSaveName" => $buttonSaveName
            ,"userID"         => $userID
            ,"checked"        => $checked
            ,"userData"       => $userData
            ,"errors"         => $errors
        );

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

        $errors = array_merge($erLogin, $erFName, $erLName, $erBDay);
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

    protected static function validateDate($date)
    {
        extract($date);

        $errors = array();

        //Day
        if($day == null)
        {
            $errors []= "Day is empty";
        }
        $options = array(
            'options' => array(
                'default' => 1
                ,'min_range' => 1
                ,'max_range' => 31
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );
        filter_var($day, FILTER_VALIDATE_INT, $options);

        //Month
        if($month == null)
        {
            $errors []= "Month is empty";
        }
        $options = array(
            'options' => array(
                'default' => 1
                ,'min_range' => 1
                ,'max_range' => 12
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );
        filter_var($month, FILTER_VALIDATE_INT, $options);

        //Year
        if($year == null)
        {
            $errors []= "Year is empty";
        }
        $options = array(
            'options' => array(
                'default' => 2021
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );
        filter_var($year, FILTER_VALIDATE_INT, $options);

        //add other logic here ...

        return $errors;
    }
}