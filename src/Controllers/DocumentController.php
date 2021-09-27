<?php

namespace Controllers;

use Controllers\DataController;
use Views\View;
use Models\DocumentModel;
use Core\Router;

class DocumentController extends DataController
{
    public function print()
    {
        $documentList = DocumentModel::getAll();
        View::render("documents", ["documentList" => $documentList]);
    }

    protected static function create()
    {        
        $vararr = array(
            "title"           => "Create",
            "buttonSaveName" => "Create",
            "documentID"         => 1 + DocumentModel::getLastJsonID(),
            "documentData"       => null
        );

        return $vararr;
    }

    protected static function edit($documentID)
    {
        $documentModel = new DocumentModel();
        $documentData = $documentModel->loadAndGetData($documentID);

        $vararr = array(
            "title"           => "Edit",
            "buttonSaveName" => "Save",
            "documentID"         => $documentID,
            "documentData"       => $documentData
        );

        return $vararr;
    }

    protected static function trySave($documentID)
    {
        $docData = [
            "organisation"      => Router::getVar("editDocOrganisation"),
            "counteragent"     => Router::getVar("editDocCounterAgent"),
            "signer"           => Router::getVar("editDocSigner"),
            "dateofcontract"   => [
                    "start"   => Router::getVar("editDocDateOfContractS"),
                    "finish" => Router::getVar("editDocDateOfContractF")
                ],
            "objectofcontract" => Router::getVar("editDocObjectOfContract"),
            "currency"         => Router::getVar("editDocCurrency"),
            "costofcontract"   => Router::getVar("editDocCostOfContract"),
            "requisites"       => [
                    "adress"  => Router::getVar("editDocReqAdress"),
                    "inn"    => Router::getVar("editDocReqINN"),
                    "chacc"  => Router::getVar("editDocReqChAcc")
                ],
            "id" => $documentID
        ];

        //Validation
        $errors = static::validateDocumentData($docData);

        if(empty($errors))
        {
            $docModel = new DocumentModel();
            $docModel->setData($docData);
            $docModel->save();
        }

        $result["data"] = $docData;
        $result["errors"] = $errors;

        return $errors;
    }

    public function editOrCreate()
    {
        $result = parent::baseEditOrCreate("documents", "editDocumentSubmit");

        $vararr = $result["vararr"];
        $vararr["errors"] = $result["errors"];
        $vararr["documentData"] = $result["data"];

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

    /*
    Validation functions
    */

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