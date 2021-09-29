<?php

namespace Controllers;

use Controllers\DataController;
use Core\View;
use Core\Router;
use Models\DocumentModel;
use Validator\Validator;

class DocumentController extends DataController
{
    public function print()
    {
        $documentList = DocumentModel::getAll();
        //View::render("documents", ["documentList" => $documentList]);
        $output = View::render("documents", ["documentList" => $documentList]);
        echo $output;
    }

    protected static function create()
    {        
        $vararr = array(
            "title"           => "Create",
            "buttonSaveName" => "Create",
            "documentData"       => null
        );

        return $vararr;
    }

    protected static function edit($documentID)
    {
        $documentData = DocumentModel::getByID($documentID);

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
            if($documentID == null)
            {
                DocumentModel::create($docData);
            }
            else
            {
                DocumentModel::update($documentID, $docData);
            }
            // $docModel = new DocumentModel();
            // $docModel->setData($docData);
            // $docModel->save();
        }

        $result["data"] = $docData;
        $result["errors"] = $errors;

        return $errors;
    }

    public function editOrCreate()
    {
        if(isset($_GET["id"]))
        {   
            $documentID = $_GET["id"];
            $documentData = DocumentModel::getByID($documentID);

            $vararr = array(
                "title"           => "Edit",
                "buttonSaveName" => "Save",
                "documentID"         => $documentID,
                "documentData"       => $documentData
            );

            //$result["vararr"] = static::edit($_GET["id"]);
        }
        else
        {
            $vararr = array(
                "title"           => "Create",
                "buttonSaveName" => "Create",
                "documentData"       => null
            );
            //$result["vararr"] = static::create();
        }

        if(count($_POST) > 0)
        {
            $id = Router::getVar("editDocumentSubmit");
            $temp = static::trySave($id);            
        
            if(count($temp["errors"]) == 0)
            {
                header("location: /documents");
                return;
            }

            $vararr["data"] = $temp["data"];
            $vararr["errors"] = $temp["errors"];
            unset($temp);
        }

        if(isset($result["data"]))
        {
            $vararr["documentData"] = $result["data"];
        }

        $output = View::render("editDocument", $vararr);
        echo $output;

        // $result = parent::baseEditOrCreate("documents", "editDocumentSubmit");

        // $vararr = $result["vararr"];
        // $vararr["errors"] = $result["errors"];

        // if(isset($result["data"]))
        // {
        //     $vararr["documentData"] = $result["data"];
        // }

        // //View::render("editDocument", $vararr);
        // $output = View::render("editDocument", $vararr);
        // echo $output;
    }

    public function delete()
    {
        DocumentModel::delete($_GET["id"]);
        header("location: /documents");
    }
}