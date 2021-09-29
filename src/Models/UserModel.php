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

    public static function create($data)
    {
        $query = "
            INSERT INTO ".self::$tableName."
            (login, first_name, last_name, bday, active)
            VALUES(
                \"".$data["login"]."\",
                \"".$data["fname"]."\",
                \"".$data["lname"]."\",
                '".$data["bday"]."',
                ".$data["active"]."
            )
        ";
        
        $inst = DBAdapter::getInstance();
        $conn = $inst->getConnection();
       
        DBAdapter::execSQL($query);

        //var_dump(mysqli_error($conn));
        //var_dump($query);
    }

    public static function update($id, $data)
    {
        $query = "
            UPDATE ".static::$tableName."
            SET
            login = \"".$data["login"]."\",
            first_name = \"".$data["fname"]."\",
            last_name = \"".$data["lname"]."\",
            bday = \"".$data["bday"]."\",
            active = \"".$data["active"]."\"
            WHERE user_id = ".$id.";
        ";
        DBAdapter::execSQL($query);
    }

    public static function delete($id)
    {
        $query = "
            DELETE FROM ".static::$tableName."
            WHERE user_id=".$id.";
        ";
        DBAdapter::execSQL($query);
    }
}