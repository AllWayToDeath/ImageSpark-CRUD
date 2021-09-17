<?php
require_once "save.php";
?>
<html>
<head>
    <title>Pseudo-Create user</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form id="backForm" method="POST" action="index.php"></form>
    <form method="GET" action="">
        <input type="text" name="createUserLogin" value="<?=$user_data["login"]?>" placeholder="Login"><br>
        <input type="text" name="createUserFname" value="<?=$user_data["fname"]?>" placeholder="1-st Name"><br>
        <input type="text" name="createUserLname" value="<?=$user_data["lname"]?>" placeholder="2-nd Name"><br>
        <paa>Birthday</paa>
        <input type="number" name="createUserBdayD" value="<?=$user_data["bday"]["day"]?>" max="31" min="1">
        <input type="number" name="createUserBdayM" value="<?=$user_data["bday"]["month"]?>" max="12" min="1">
        <input type="number" name="createUserBdayY" value="<?=$user_data["bday"]["year"]?>" max="2021" min="0"><br>
        
        <label>
            <input type="checkbox" name="createUserActive" id="active" name="active" value="checked" <?=$user_data["active"]?>>
            <paa>Active</paa>
        </label>
        
        <br>
        <button id="addUser" name="createUserSubmit" type="submit" >Create</button>
        <button id="cancel" type="submit" form="backForm" >Back</button>
    </form>
    <p><? printErrors() ?></p>
</body>
</html>