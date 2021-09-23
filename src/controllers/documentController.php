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
        // $editableUser = new UserModel;
        // $editableUser->loadDataFromJSON($_GET["id"]);

        /*
        Вызов getVar где-то здесь, но не позже
        */

        //Или нужно компановать все данные в отдельный массив?
        //View::render("editUser", $_GET);

        /*
        DocEd

        require_once "save.php";

        $title = "Create";
        $buttonSaveName = "Create";
        $documentID = null;

        if(isset($_GET["id"]))
        {
            $documentData = loadDocument($_GET["id"]);
            $title = "Edit";
            $buttonSaveName = "Save";
            $documentID = $_GET["id"];
        }
        */


    }

    public function delete()
    {
        //UserModel::deleteByID($_GET["id"]);
    }
}