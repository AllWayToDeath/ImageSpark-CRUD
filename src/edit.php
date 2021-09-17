<?php
require_once "save.php";

$title = "Create";
$buttonSaveName = "Create";

if(isset($_GET["id"]))
{
    $userData = loadUser(SAVEPATH, $_GET["id"]);
    $checked = getCheckedStatus($userData["active"]);
    $title = "Edit";
    $buttonSaveName = "Save";
}

?>
<html>
<head>
    <title>Pseudo-<?=$title?> user</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form id="backForm" method="POST" action="index.php"></form>
    <form method="GET" action="">
        <input type="text" name="editUserLogin" value="<?=$userData["login"]?>" placeholder="Login"><br>
        <input type="text" name="editUserFname" value="<?=$userData["fname"]?>" placeholder="1-st Name"><br>
        <input type="text" name="editUserLname" value="<?=$userData["lname"]?>" placeholder="2-nd Name"><br>
        <paa>Birthday</paa>
        <input type="number" name="editUserBdayD" value="<?=$userData["bday"]["day"]?>" max="31" min="1">
        <input type="number" name="editUserBdayM" value="<?=$userData["bday"]["month"]?>" max="12" min="1">
        <input type="number" name="editUserBdayY" value="<?=$userData["bday"]["year"]?>" max="2021" min="0"><br>
        
        <label>
            <input type="checkbox" name="editUserActive" id="active" name="active" value="checked" <?=$userData["active"]?>>
            <paa>Active</paa>
        </label>
        
        <br>
        <button id="addUser" name="editUserSubmit" type="submit" value="<?=$_GET["id"]?>" ><?=$buttonSaveName?></button>
        <button id="cancel" type="submit" form="backForm" >Back</button>
    </form>
    <p><? printErrors() ?></p>
</body>
</html>
<!-- ================================================================= -->