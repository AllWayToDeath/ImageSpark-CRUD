<html>
<head>
    <title><?=$title?> document</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../../styles/styleButtonsA.css">
    <style>
        td#req{
            text-align: left;
        }
    </style>
</head>
<body>
    <table>
    <form method="POST" action="">
        <tr>
            <td><paa>Name of organisation</paa></td>
            <td><input type="text" name="editDocOrganisation" value="<?=$documentData["organisation"]?>" placeholder="Name of organisation"></td>
        </tr>
        <tr>
            <td><paa>Counter agent</paa></td>
            <td><input type="text" name="editDocCounterAgent" value="<?=$documentData["counteragent"]?>" placeholder="Counter agent"></td>
        </tr>
        <tr>
            <td><paa>Signer</paa></td>
            <td><input type="text" name="editDocSigner" value="<?=$documentData["signer"]?>" placeholder="Signer"></td>
        </tr>
        <tr>
            <td><paa>Start date of contract</paa></td>
            <td><input type="date" name="editDocDateOfContractS" value="<?=$documentData["dateofcontract"]["start"]?>" placeholder="DoC"></td>
        </tr>
        <tr>
            <td><paa>Finish date of contract</paa></td>
            <td><input type="date" name="editDocDateOfContractF" value="<?=$documentData["dateofcontract"]["finish"]?>" placeholder="DoC"></td>
        </tr>
        <tr>
            <td><paa>Object of contract</paa></td>
            <td><input type="text" name="editDocObjectOfContract" value="<?=$documentData["objectofcontract"]?>" placeholder="Object of contract"></td>
        </tr>
        <tr>
            <td><paa>Cost of contract</paa></td>
            <td>
                <select name="editDocCurrency">
                    <option>₽</option>
                    <option>$</option>
                    <option>€</option>
                </select> 
                <input type="number" name="editDocCostOfContract" value="<?=$documentData["costofcontract"]?>" placeholder="499.99" min="0.00" max="1000000000.00" step="0.01" />
            </td>
        </tr>
        <tr>
            <td id="req" colspan="2"><paa>Requisites</paa></td>
            <td></td>
        </tr>
        <tr>
            <td><paa>address</paa></td>
            <td><input type="text" name="editDocReqaddress" value="<?=$documentData["requisites"]["address"]?>" placeholder="Wall Street, 8a"></td>
        </tr>
        <tr>
            <td><paa>INN</paa></td>
            <td><input type="text" name="editDocReqINN" value="<?=$documentData["requisites"]["inn"]?>" placeholder="1234567890"></td>
        </tr>
        <tr>
            <td><paa>Сhecking account</paa></td>
            <td><input type="text" name="editDocReqChAcc" value="<?=$documentData["requisites"]["chacc"]?>" placeholder="Account"></td>
        </tr>      
        
        <tr>
            <td><button id="add" name="editDocumentSubmit" type="submit" value="<?=$documentID?>" ><?=$buttonSaveName?></button></td>
            <td><a id="back" href="/documents">Back</a></td>
        </tr>
    </form>
    </table>
    <p><?
    foreach($errors as $err)
    {
        echo "$err<br>";
    }
    ?></p>
</body>
</html>
<!-- ================================================================= -->