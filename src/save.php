<?php

require_once "functions.php";

$user_data = array(
    "login"     => ""
    ,"fname"    => ""
    ,"lname"    => ""
    ,"bday"     => array(
        "day"       => ""
        ,"month"    => ""
        ,"year"     => ""
        )
    ,"active"   => getActiveStatus("checked")
);

$error_message;

if(isset($_GET["editUserSubmit"]))
{
    $userData = getUserDataFromForm();

    $id = null;
    if(!isset($_GET["id"]))
    {
        $id = $_GET["editUserSubmit"];
    }
    if(null != $id)
        $_GET["id"] = $id;

    saveWithValidation($userData, $id, "Data is not correct!");
}

function getUserDataFromForm()
{
    $user_data = array(
        "login"     => smartGet("editUserLogin")
        ,"fname"    => smartGet("editUserFname")
        ,"lname"    => smartGet("editUserLname")
        ,"bday"     => getBday("editUser")
        ,"active"   => getActiveStatus(smartGet("editUserActive"))
    );
    return $user_data;
}

function isComplete($user_data)
{
    $complete = true;

    foreach($user_data as $key => $ud)
    {
        if(is_array($ud))
        {
            if(!isComplete($ud))
            {
                $complete = false;
                break;
            }
        }
        if("" == $ud)
        {
            $complete = false;
            break;
        }
    }
    return $complete;
}

function getActiveStatus($data)
{
    return ("" == $data) ?
        "No":
        "Yes";
}
function getCheckedStatus($data)
{
    return ("Yes" == $data) ?
        "checked":
        null;
}

function smartGet(string $id)
{
    $value = $_GET[$id];

    if(null == $value)
    {
        $value = "";
    }
    return $value;
}

function getBday(string $prefix)
{
    $bday = array(
        "day"     => smartGet($prefix."BdayD")
        ,"month"  => smartGet($prefix."BdayM")
        ,"year"   => smartGet($prefix."BdayY")
    );
    return $bday;
}