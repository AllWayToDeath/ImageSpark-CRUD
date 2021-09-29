<?php

namespace Models;

use Core\DBAdapter;

class DocumentModel extends DBModel
{
    public const SAVEPATH = "./data/documents/";

    protected static $tableName = "documents";
    protected static $idName = "document_id";

    /*Функции конвертации данных*/
    public static function convertDataToSQLData($data)
    {
        $sqlData = array();
        $sqlDateS = parent::convertDateToSQLDate($data["dateofcontract"]["start"]);
        $sqlDateF = parent::convertDateToSQLDate($data["dateofcontract"]["finish"]);

        $sqlData []= array("organisation", "\"".$data["logorganisationin"]."\"");
        $sqlData []= array("counteragent", "\"".$data["counteragent"]."\"");
        $sqlData []= array("signer", "\"".$data["signer"]."\"");
        $sqlData []= array("dateofcontract_start", "'".$sqlDateS."'");
        $sqlData []= array("dateofcontract_finish", "'".$sqlDateF."'");
        $sqlData []= array("objectofcontract", "\"".$data["objectofcontract"]."\"");
        $sqlData []= array("currency", "\"".$data["currency"]."\"");
        $sqlData []= array("costofcontract", $data["costofcontract"]);
        $sqlData []= array("req_address", "\"".$data["req_address"]."\"");
        $sqlData []= array("req_inn", $data["req_inn"]);
        $sqlData []= array("req_chacc", "\"".$data["req_chacc"]."\"");

        return $sqlData;
    }
}