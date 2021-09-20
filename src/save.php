<?php

/*
Need refactoring!
*/

require_once "functions.php";
const IDINFONAME    = "idinfo.txt";

function saveUniversal($folder, $data, $id = null)
{
    $jsonData = json_encode($data);
    $nextID = $id;

    if(null == $id)
    {
        $nextID = 1 + getLastJsonID($folder);
    }

    $fullPath = $folder . "$nextID.json";
    file_put_contents($folder.IDINFONAME, $nextID);
    file_put_contents($fullPath, $jsonData);
}

function loadDataFromJSON($path, $id)
{
    if (!is_dir($path))
        return null;

    $fileName = $path . $id . ".json";
    $jsonData = file_get_contents($fileName);
    $result = json_decode($jsonData, true);
    return $result;
}

function saveWithValidation($data, $id, $folder, $location, $errMsg = "Error!")
{
    if(isComplete($data))
    {
        saveUniversal($folder, $data, $id);
        $head = "Location: $location";
        //header($head);
    }
    else
    {
        addError($errMsg);
    }
}

/*==========|Users|==========*/
const SAVEPATHUSER  = "./data/users/";

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

    
    $full_path = SAVEPATHUSER . "$next_id.json";
    file_put_contents(SAVEPATHUSER.IDINFONAME, $next_id);
    file_put_contents($full_path, $json_user);
}

function loadUser($path = SAVEPATHUSER, $id)
{
    if (!is_dir($path))
        return null;

    $file_name = $path . $id . ".json";
    $raw_result = file_get_contents($file_name);
    $result = json_decode($raw_result, true);
    return $result;
}

function saveUserWithValidation($userData, $id, $errMsg)
{
    if(isComplete($userData))
    {
        saveUser($userData, $id);
        header("Location: users.php");
    }
    else
    {
        addError($errMsg);
    }
}

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

    saveUserWithValidation($userData, $id, "Data is not correct!");
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

function getBday(string $prefix)
{
    $bday = array(
        "day"     => smartGet($prefix."BdayD")
        ,"month"  => smartGet($prefix."BdayM")
        ,"year"   => smartGet($prefix."BdayY")
    );
    return $bday;
}


/*==========|Documents|==========*/
const SAVEPATHDOCUMENT  = "./data/documents/";

function getDocumentDataFromForm()
{
    $documentData = array(
        "organisation"      => smartGet("editDocOrganisation")
        ,"counteragent"     => smartGet("editDocCounterAgent")
        ,"signer"           => smartGet("editDocSigner")
        ,"dateofcontract"   => getDoC("editDoc")
        ,"objectofcontract" => smartGet("editDocObjectOfContract")
        ,"currency"         => smartGet("editDocCurrency")
        ,"costofcontract"   => smartGet("editDocCostOfContract")
        ,"requisites"       => getReq("editDoc")
    );
    return $documentData;
}

function getDoC(string $prefix)
{
    $dofC = array(
        "finish"  => smartGet($prefix."DateOfContractF")
        ,"start"  => smartGet($prefix."DateOfContractS")
    );
    return $dofC;
}
function getReq(string $prefix)
{
    $req = array(
        "adress" => smartGet($prefix."ReqAdress")
        ,"inn"   => smartGet($prefix."ReqINN")
        ,"chacc" => smartGet($prefix."ReqChAcc")
    );
    return $req;
}

if(isset($_GET["editDocumentSubmit"]))
{
    $documentData = getDocumentDataFromForm();

    $id = null;
    if(!isset($_GET["id"]))
    {
        $id = $_GET["editDocumentSubmit"];
    }
    if(null != $id)
        $_GET["id"] = $id;

    //saveWithValidation($documentData, $id, SAVEPATHDOCUMENT, "documents.php", $errMsg);
    saveDocumentWithValidation($documentData, $id, "Data is not correct!");
}

function saveDocumentWithValidation($documentData, $id, $errMsg = "Error!")
{
    //saveWithValidation($documentData, $id, SAVEPATHDOCUMENT, $location, $errMsg);
    //saveWithValidation($data, $id, $folder, $location, $errMsg = "Error!")
    if(isComplete($documentData))
    {
        saveDocument($documentData, $id);
        header("Location: documents.php");
    }
    else
    {
        addError($errMsg);
    }
}

function saveDocument($doc, $id = null)
{
    saveUniversal(SAVEPATHDOCUMENT, $doc, $id);
    /*
    $jsonDoc = json_encode($doc);
    $nextID = $id;

    if(null == $id)
    {
        $nextID = 1 + getLastJsonID();
    }

    $fullPath = SAVEPATHDOCUMENT . "$nextID.json";
    file_put_contents(SAVEPATHDOCUMENT.IDINFONAME, $nextID);
    file_put_contents($fullPath, $jsonDoc);
    */
}

function loadDocument($path = SAVEPATHDOCUMENT, $id)
{
    return loadDataFromJSON(SAVEPATHDOCUMENT, $id);
    /*
    if (!is_dir($path))
        return null;

    $fileName = $path . $id . ".json";
    $rawResult = file_get_contents($fileName);
    $result = json_decode($rawResult, true);
    return $result;
    */
}