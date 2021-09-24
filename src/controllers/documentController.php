<?php

require_once "functions.php";
require_once "controller.php";
require_once "models/documentModel.php";

class DocumentController extends Controller
{
    public function print()
    {
        $documentList = DocumentModel::getAll();
        View::render("documents", ["documentList" => $documentList]);
    }

    public function edit()
    {
        $title = "Create";
        $buttonSaveName = "Create";
        $documentID = null;

        $arrData = null;
        $dataIsLoaded = false;

        if(isset($_GET["id"]))
        {
            $title = "Edit";
            $buttonSaveName = "Save";
            $documentID = $_GET["id"];

            $documentData = new DocumentModel();
            $dataIsLoaded = $documentData->loadDataFromJSON($_GET["id"]);
            
            if($dataIsLoaded)
            {
                $arrData = $documentData->getData();
            }
        }

        if(count($_POST) > 0)
        {
            $docData = [
                "organisation"      => Router::getVar("editDocOrganisation")
                ,"counteragent"     => Router::getVar("editDocCounterAgent")
                ,"signer"           => Router::getVar("editDocSigner")
                ,"dateofcontract"   => [
                        "start"   => Router::getVar("editDocDateOfContractS")
                        ,"finish" => Router::getVar("editDocDateOfContractF")
                        ]
                ,"objectofcontract" => Router::getVar("editDocObjectOfContract")
                ,"currency"         => Router::getVar("editDocCurrency")
                ,"costofcontract"   => Router::getVar("editDocCostOfContract")
                ,"requisites"       => [
                        "adress"  => Router::getVar("editDocReqAdress")
                        ,"inn"    => Router::getVar("editDocReqINN")
                        ,"chacc"  => Router::getVar("editDocReqChAcc")
                        ]
            ];

            if(isset($_POST["editDocumentSubmit"]) && null != $_POST["editDocumentSubmit"])
            {
                $docData["id"] = $_POST["editDocumentSubmit"];
            }
            else{
                $docData["id"] = 1 + getLastJsonID(UserModel::SAVEPATH, UserModel::IDINFONAME);
            }

            if(isComplete($docData))
            {
                $doc = new DocumentModel();
                $doc->setData($docData);
                $doc->save();
                header("location: /documents");
                return;
            }
        }
        
        $vararr = array(
            "title"           => $title
            ,"buttonSaveName" => $buttonSaveName
            ,"documentID"     => $documentID
            ,"documentData"   => $arrData
        );

        View::render("editDocument", $vararr);
    }

    public function delete()
    {
        DocumentModel::deleteByID($_GET["id"]);
        header("location: /documents");
    }

    protected static function validateDocumentData($userData)
    {
        extract($userData);

        $errors = array_merge(
            static::validateTitleName($organisation, "Organisation")
            ,static::validateTitleName($counteragent, "counteragent")
            ,static::validateTitleName($signer, "signer")
            ,static::validateDate($dateofcontract["start"])
            ,static::validateDate($dateofcontract["finish"])
            ,static::validateTitleName($objectofcontract, "objectofcontract")
            ,static::validateCurrency($currency)
            ,static::validateCost($costofcontract)
            ,static::validateAdress($requisites["adress"])
            ,static::validateINN($requisites["inn"])
            ,static::validateAccount($requisites["chacc"])
        );
        return $errors;
    }

    protected static function validateTitleName($name, $fieldName)
    {
        $errors = array();

        if($name == null)
        {
            $errors []= "$fieldName is empty";
        }
        //Разрешить цифры и разобраться с регулярными выражениями
        if(! preg_match("/^[a-zA-z]*$/", $name))
        {
            $errors []= "$fieldName contain a wrong symbol";
        }
        return $errors;
    }

    protected static function validateAccount($acc)
    {
        $errors = array();

        if($acc == null)
        {
            $errors []= "Account is empty";
        }

        return $errors;
    }

    protected static function validateCurrency($currency)
    {
        $errors = array();

        if($currency == null)
        {
            $errors []= "Currency is empty";
        }

        return $errors;
    }
    protected static function validateCost($cost)
    {
        $errors = array();

        if($cost == null)
        {
            $errors []= "Cost is empty";
        }
        if(!filter_var($cost, FILTER_VALIDATE_INT))
        {
            $errors []= "Cost is wrong";
        }
        if($cost < 0)
        {
            $errors []= "Cost is low";
        }

        return $errors;
    }

    protected static function validateAdress($adress)
    {
        $errors = array();

        if($adress == null)
        {
            $errors []= "Adress is empty";
        }

        return $errors;
    }
    protected static function validateINN($inn)
    {
        $errors = array();

        if($inn == null)
        {
            $errors []= "INN is empty";
        }
        if(!filter_var($inn, FILTER_VALIDATE_INT))
        {
            $errors []= "INN is wrong";
        }
        if(strlen((string)$inn) != 12)
        {
            $errors []= "INN is wrong";
        }

        return $errors;
    }
}