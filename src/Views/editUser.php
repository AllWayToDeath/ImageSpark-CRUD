<html>
<head>
    <title><?=$title?> user</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/styleButtonsA.css">
</head>
<body>
    <form method="POST" action="">
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
        <button id="addUser" name="editUserSubmit" type="submit" value="<?=$userID?>" ><?=$buttonSaveName?></button>
        <a id="back" href="/users">Back</a>

    </form>
    <p>
        <? foreach($errors as $error)
        {
            echo $error . "<br>";
        } ?>
    </p>
</body>
</html>
<!-- ================================================================= -->