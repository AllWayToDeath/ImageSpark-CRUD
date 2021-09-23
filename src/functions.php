<?php

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

function getLastJsonID($path = SAVEPATHUSER)
{
    $path .= IDINFONAME;
    if (!file_exists($path)) {
        var_dump("here");
        createIdInfo();
    }
    $last_id = file_get_contents($path);
    return $last_id;
}

function createIdInfo($path = SAVEPATHUSER)
{
    $last_id = 0;
    $full_path = SAVEPATHUSER . IDINFONAME;
    var_dump($full_path);
    file_put_contents($full_path, $last_id);
}

function isComplete($data)
{
    $complete = true;

    foreach($data as $key => $ud)
    {
        if(is_array($ud))
        {
            if(!isComplete($ud))
            {
                $complete = false;
                break;
            }
        }
        if("" == $ud || null == $ud)
        {
            $complete = false;
            break;
        }
    }
    return $complete;
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

function deleteExtensionJSON(string $file)
{
    //analog 'str_replace'
    $len = strlen($file);
    return substr($file, 0, $len-5);
}

function getCheckedStatus($data)
{
    return ("Yes" == $data) ?
        "checked":
        null;
}