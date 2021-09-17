<?php
require_once "functions.php";
$fileName = $_GET["id"].".json";
$successDelete = unlink(SAVEPATH.$fileName);

if($successDelete)
{
    header("Location: index.php");
}
?>

<html>
<head>
    <title>Pseudo-Delete user</title>
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