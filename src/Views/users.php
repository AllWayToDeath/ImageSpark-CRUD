<html>
<head>
    <title>Users</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleButtonsA.css">
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
        p1#knopki{
            text-decoration: underline;
        }
    </style>
</head>

<body>
    
    <form id="form1" action="/edit/user" method="POST"></form>

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
                //var_dump($userList);
                foreach($userList as $user)
                {
                    $id = $user["user_id"];
                    //var_dump($user["bday"]);

                    $tmpDate = explode("-", $user["bday"]);
                    $user["bday"] = array(
                        "day" => $tmpDate[2],
                        "month" => $tmpDate[1],
                        "year" => $tmpDate[0]
                    );
            ?>

            <tr>
                <td>
                    <p><?=$user["login"];?></p>
                </td>
                <td>
                    <p><?=$user["first_name"];?></p>
                </td>
                <td>
                    <p><?=$user["last_name"];?></p>
                </td>
                <td>
                    <p><?=$user["bday"]["day"];?>.<?=$user["bday"]["month"];?>.<?=$user["bday"]["year"];?></p>
                </td>
                <td id="active">
                    <p><?=$user["active"];?></p>
                </td>
                <td>
                    <a id="edit" href="/edit/user?id=<?=$id?>">
                        Edit</a>
                    <a id="delete" href="/delete/user?id=<?=$id?>">
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
    <a id="back" href="/menu">To main page</a>
</body>
</html>