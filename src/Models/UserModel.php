<?php

namespace Models;

use Core\DBAdapter;

class UserModel extends DBModel
{
    public const SAVEPATH = "./data/users/";

    public static function getActiveStatus($data)
    {
        return ("" == $data) ?
            "No":
            "Yes";
    }
    /*===================================================*/

    protected static $tableName = "users";
    protected static $idName = "user_id";

    /*Функции конвертации данных*/
    public static function convertDataToSQLData($data)
    {
        $sqlData = array();
        $sqlDate = parent::convertDateToSQLDate($data["bday"]);

        $sqlData []= array("login", "\"".$data["login"]."\"");
        $sqlData []= array("fname", "\"".$data["fname"]."\"");
        $sqlData []= array("lname", "\"".$data["lname"]."\"");
        $sqlData []= array("bday", "'".$sqlDate."'");

        $active = ($data["active"] == "No") ? 0 : 1;
        $sqlData []= array("active", $active);

        return $sqlData;
    }
}