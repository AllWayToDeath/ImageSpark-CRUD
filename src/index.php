<html>
<head>
    <title>IT WORKS!</title>
    <link rel="stylesheet" href="styles/style.css">
    <style>
        table#users{
            background-color: transparent;
            border-spacing: 15 3
        }
        td#active{
            text-align: center;
        }
        #addUser{
            height:32px;
            width:32px;
        }
        td#headerUsers{
            text-align: right;
            width: 50%;
        }
        a#edit{
            color: #bbeebb;
        }
        a#delete{
            color: #eebbbb;
        }
        p1#knopki{
            text-decoration: underline;
        }
    </style>
</head>

<body>
    
    <form id="form1" action="create.php" method="POST"></form>

    <table>
    <tr>
        <td id="headerUsers">
            <p2>Users</p2>
        </td>
        
        <td>
            <button id="addUser" type="submit" form="form1">+</button>
        </td>
    </tr>
    <tr >
        <td colspan="2">
        <table id="users">
            <tr>
                <th>
                    <p1>Login</p1>
                </th>
                <th>
                    <p1>First name</p1>
                </th>
                <th>
                    <p1>Last name</p1>
                </th>
                <th>
                    <p1>B-day</p1>
                </th>
                <th>
                    <p1>Active</p1>
                </th>
                <th>
                    <p1 id="knopki">_Knopki_</p1>
                </th>
            </tr>

            <?php
                require_once "functions.php";

                function deleteExtensionJSON(string $file)
                {
                    //analog 'str_replace'
                    $len = strlen($file);
                    return substr($file, 0, $len-5);
                }

                foreach(scandir(SAVEPATH) as $file_json)
                {
                    if(!isJSON($file_json))
                        continue;

                    $id = deleteExtensionJSON($file_json);
                    $user = loadUser(SAVEPATH, $id);
            ?>

            <tr>
                <td>
                    <p><?=$user["login"];?></p>
                </td>
                <td>
                    <p><?=$user["fname"];?></p>
                </td>
                <td>
                    <p><?=$user["lname"];?></p>
                </td>
                <td>
                    <p><?=$user["bday"]["day"];?>.<?=$user["bday"]["month"];?>.<?=$user["bday"]["year"];?></p>
                </td>
                <td id="active">
                    <p><?=$user["active"];?></p>
                </td>
                <td>
                    <a id="edit" href="update.php?id=<?=$id?>">
                        Edit</a>
                    <a id="delete" href="delete.php?id=<?=$id?>">
                        Delete</a>
                </td>
            </tr>

            <?php
                }
            ?>
        </table>
        </td>
    </tr>
    </table>
</body>
</html>