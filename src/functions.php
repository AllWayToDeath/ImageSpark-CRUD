<?php

const SAVEPATH  = "./data/users/";
const IDINFONAME    = "idinfo.txt";

function addError(string $errMsg)
{
    $_POST["errorPool"] [] = $errMsg;
}

function printErrors()
{
    if(!isset($_POST["errorPool"]))
    {
        return;
    }
    foreach($_POST["errorPool"] as $error)
    {
        echo $error;
    }
}

function saveWithValidation($userData, $id, $errMsg)
{
    if(isComplete($userData))
    {
        saveUser($userData, $id);
        header("Location: index.php");
    }
    else
    {
        addError($errMsg);
    }
}

function isFullness($userData)
{
    $fullness = true;

    foreach($userData as $key => $value)
    {
        if("" == $value || null == $value)
        {
            $fullness = false;
            break;
        }
    }
    return $fullness;
}

function saveUser($user, $id = null)
{
    $json_user = json_encode($user);

    if(null == $id)
    {
        $next_id = 1 + getLastJsonID();
    }
    else
    {
        $next_id = $id;
    }

    
    $full_path = SAVEPATH . "$next_id.json";
    file_put_contents(SAVEPATH.IDINFONAME, $next_id);
    file_put_contents($full_path, $json_user);
}

function loadUser($path = SAVEPATH, $id)
{
    if (!is_dir($path))
        return null;

    $file_name = SAVEPATH . $id . ".json";
    $raw_result = file_get_contents($file_name);
    $result = json_decode($raw_result, true);
    return $result;
}

function isJSON($path)
{
    if (is_dir($path))
        return false;

    $is_json = false;
    $ext = substr($path, -5);
    if (".json" == $ext) {
        $is_json = true;
    }
    return $is_json;
}

function getLastJsonID($path = SAVEPATH)
{
    $path .= IDINFONAME;
    if (!file_exists($path)) {
        var_dump("here");
        createIdInfo();
    }
    $last_id = file_get_contents($path);
    return $last_id;
}

function createIdInfo($path = SAVEPATH)
{
    $last_id = 0;
    $full_path = SAVEPATH . IDINFONAME;
    var_dump($full_path);
    file_put_contents($full_path, $last_id);
}
