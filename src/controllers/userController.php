<?php

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

        if(isset($_GET["id"]))
        {
            var_dump("GET-ID = ", $_GET["id"]);

            $title = "Edit";
            $buttonSaveName = "Save";
            $userID = $_GET["id"];

            $userData = new UserModel;
            $userData->loadDataFromJSON($_GET["id"]);
            var_dump("UC UD = ", $userData);

            //Checker
            $getCheckedStatus = function($data)
            {
                return ("Yes" == $data) ?
                    "checked":
                    null;
            };
            $activeStatus = $userData->getData()["active"];
            $checked = $getCheckedStatus($activeStatus);
        }
        
        $vararr = array(
            "title"           => $title
            ,"buttonSaveName" => $buttonSaveName
            ,"userID"         => $userID
            ,"checked"        => $checked
            ,"userData"       => $userData->getData()
        );

        View::render("editUser", $vararr);
    }

    public function delete()
    {
        UserModel::deleteByID($_GET["id"]);
    }
}