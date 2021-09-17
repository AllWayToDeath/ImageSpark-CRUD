<?php
require_once "functions.php";

printAllUserJSON();

function printAllUserJSON()
{
    //TODO
    foreach(scandir(SAVEPATH) as $file_json)
    {
        if(!isJSON($file_json))
            continue;

        $id = deleteExtensionJSON($file_json);
        $user = loadUser(SAVEPATH, $id);

        printUser($id, $user);
    }
}

function printUser($id, $user)
{
    echo "$id) ";
    print_r($user);
    echo "\n";
}

function deleteExtensionJSON(string $file)
{
    $len = strlen($file);
    return substr($file, 0, $len-5);
}

function loadUser($path = SAVEPATH, $id)
{
    if (!is_dir($path))
        return null;

    $file_name = SAVEPATH . $id . ".json";
    //var_dump("VAR_DUMP! $file_name");
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