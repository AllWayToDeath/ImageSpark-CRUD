<?php

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
    }
}