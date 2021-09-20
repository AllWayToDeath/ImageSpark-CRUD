<?php
require_once "save.php";
$fileName = $_GET["id"].".json";
$successDelete = unlink(SAVEPATHUSER.$fileName);

if($successDelete)
{
    header("Location: users.php");
}
?>

<html>
<head>
    <title>Delete user</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        a{
            color: white;
        }
    </style>
</head>
<body>
    <a href="index.php">No Delete</a>
</body>
</html>