<?php

require_once "functions.php";
const IDINFONAME    = "idinfo.txt";

function saveUniversal($folder, $data, $id = null)
{
    $jsonData = json_encode($data);
    $nextID = $id;

    if(null == $id)
    {
        $nextID = 1 + getLastJsonID($folder, IDINFONAME);
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

function getId(string $submitName)
{
    $id = null;
    if(!isset($_GET["id"]))
    {
        $id = $_GET[$submitName];
    }
    if(null != $id)
        $_GET["id"] = $id;
    
    return $id;
}


/*==========|Users|==========*/
const SAVEPATHUSER  = "./data/users/";

if(isset($_GET["editUserSubmit"]))
{
    $userData = getUserDataFromForm();
    $id = getId("editUserSubmit");
    saveUserWithValidation($userData, $id, "Data is not correct!");
}

function saveUser($user, $id = null)
{
    saveUniversal(SAVEPATHUSER, $user, $id);
}
function loadUser($id)
{
    return loadDataFromJSON(SAVEPATHUSER, $id);
}
function saveUserWithValidation($userData, $id, $errMsg)
{
    if(isComplete($userData))
    {
        saveUser($userData, $id);
        header("Location: /users");
    }
    else
    {
        addError($errMsg);
    }
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

if(isset($_GET["editDocumentSubmit"]))
{
    $documentData = getDocumentDataFromForm();
    $id = getId("editDocumentSubmit");
    saveDocumentWithValidation($documentData, $id, "Data is not correct!");
}

function saveDocumentWithValidation($documentData, $id, $errMsg = "Error!")
{
    if(isComplete($documentData))
    {
        saveDocument($documentData, $id);
        header("Location: /documents");
    }
    else
    {
        addError($errMsg);
    }
}
function saveDocument($doc, $id = null)
{
    saveUniversal(SAVEPATHDOCUMENT, $doc, $id);
}
function loadDocument($id)
{
    return loadDataFromJSON(SAVEPATHDOCUMENT, $id);
}

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