<?php

namespace Controllers;

use Controllers\DataController;
use Core\View;
use Models\DocumentModel;
use Core\Router;
use Validator\Validator;

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
        $errors = Validator::validateDocumentData($docData);

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
}