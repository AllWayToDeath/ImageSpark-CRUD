<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Documents</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleButtonsA.css">

    <style>
        table#documents{
            background-color: transparent;
            border-spacing: 15 3
        }
        td#active{
            text-align: center;
        }
        td#header{
            text-align: right;
            width: 50%;
        }
        p1#knopki{
            text-decoration: underline;
        }
    </style>

</head>
<body>
<table>
    <tr>
        <td id="header">
            <p2>Documents</p2>
        </td>
        
        <td>
            <a id="add" href="editDocument.php">+</a>
        </td>
    </tr>
    <tr >
        <td colspan="2">
        <table id="documents">
            <tr>
                <th>
                    <p1>Organisation</p1>
                </th>
                <th>
                    <p1>CounterAgent</p1>
                </th>
                <th>
                    <p1>Signer</p1>
                </th>
                <th>
                    <p1>Date of contract</p1>
                </th>
                <th>
                    <p1>Object of contract</p1>
                </th>
                <th>
                    <p1>Cost of contract</p1>
                </th>
                <th>
                    <p1>Requisites</p1>
                </th>
                <th>
                    <p1 id="knopki">_Knopki_</p1>
                </th>
            </tr>

            <?php
                foreach($documentList as $document)
                {
            ?>

            <tr>
                <td>
                    <p><?=$document["organisation"];?></p>
                </td>
                <td>
                    <p><?=$document["counteragent"];?></p>
                </td>
                <td>
                    <p><?=$document["signer"];?></p>
                </td>
                <td>
                    <p><?=$document["dateofcontract"]["start"];?></p>
                    <p><?=$document["dateofcontract"]["finish"];?></p>
                </td>
                <td>
                    <p><?=$document["objectofcontract"];?></p>
                </td>
                <td>
                    <p><?=$document["costofcontract"];?><?=$document["currency"];?></p>
                </td>
                <td>
                    <p><?=$document["requisites"]["adress"];?></p>
                    <p><?=$document["requisites"]["inn"];?></p>
                    <p><?=$document["requisites"]["chacc"];?></p>
                </td>

                <td>
                    <a id="edit" href="/edit/document?id=<?=$id?>">
                        Edit</a>
                    <a id="delete" href="/delete/document?id=<?=$id?>">
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