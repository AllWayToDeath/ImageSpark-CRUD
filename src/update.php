<?php
require_once "save.php";

$userData = loadUser(SAVEPATH, $_GET["id"]);
$checked = getCheckedStatus($userData["active"]);
?>
<html>
<head>
    <title>Pseudo-Edit user</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form id="backForm" method="POST" action="index.php"></form>
    <form method="GET" action="">
        <input type="text" id="login" name="updateUserLogin" placeholder="Login" value="<?=$userData["login"]?>"><br>
        <input type="text" id="fname" name="updateUserFname" placeholder="1-st Name" value="<?=$userData["fname"]?>"><br>
        <input type="text" id="lname" name="updateUserLname" placeholder="2-nd Name" value="<?=$userData["lname"]?>"><br>
        <paa>Birthday</paa>
        <input type="number" id="day" name="updateUserBdayD" value="<?=(int)$userData["bday"]["day"]?>" max="31" min="1">
        <input type="number" id="month" name="updateUserBdayM" value="<?=(int)$userData["bday"]["month"]?>" max="12" min="1">
        <input type="number" id="year" name="updateUserBdayY" value="<?=(int)$userData["bday"]["year"]?>" max="2021" min="0"><br>
        
        <label>
            <input type="checkbox" id="active" name="updateUserActive" name="active" <?=$checked?> >
            <paa>Active</paa>
        </label>
        
        <br>
        <button id="updateUserSubmit" name="updateUserSubmit" type="submit" value="<?=$_GET["id"]?>">Update</button>
        <button id="cancel" type="submit" form="backForm" >Back</button>
    </form>
    <p><? printErrors() ?></p>
</body>
</html>