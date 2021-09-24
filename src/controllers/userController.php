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

        $arrData = null;
        $dataIsLoaded = false;

        if(isset($_GET["id"]))
        {
            $title = "Edit";
            $buttonSaveName = "Save";
            $userID = $_GET["id"];

            $userData = new UserModel();
            $dataIsLoaded = $userData->loadDataFromJSON($_GET["id"]);
            
            if($dataIsLoaded)
            {
                $arrData = $userData->getData();
            }
            $activeStatus = $arrData["active"];
            $checked = getCheckedStatus($activeStatus);
        }

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

            if(isset($_POST["editUserSubmit"]) && null != $_POST["editUserSubmit"])
            {
                $userData["id"] = $_POST["editUserSubmit"];
            }else{
                $userData["id"] = 1 + getLastJsonID(UserModel::SAVEPATH, UserModel::IDINFONAME);
            }

            if(isComplete($userData))
            {
                $user = new UserModel();
                $user->setData($userData);
                $user->save();
                header("location: /users");
                return;
            }
        }

        $vararr = array(
            "title"           => $title
            ,"buttonSaveName" => $buttonSaveName
            ,"userID"         => $userID
            ,"checked"        => $checked
            ,"userData"       => $arrData
        );

        View::render("editUser", $vararr);
    }

    public function delete()
    {
        UserModel::deleteByID($_GET["id"]);
        header("location: /users");
    }
}