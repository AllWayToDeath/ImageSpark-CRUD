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
}