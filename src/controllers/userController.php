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

            //Checker
            $getCheckedStatus = function($data)
            {
                return ("Yes" == $data) ?
                    "checked":
                    null;
            };
            $activeStatus = $arrData["active"];
            $checked = $getCheckedStatus($activeStatus);
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
    }
}