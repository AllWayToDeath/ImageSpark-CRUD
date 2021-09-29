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

    protected $tableName = "users";
    protected $idName = "user_id";

    public function create($data)
    {
        $query = "
            INSERT INTO ".$this->tableName."
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

    public function update($id, $data)
    {
        /* // Нахер надо...
        $changeStrings = array();

        if(isset($data["login"]))
        {
            $changeString []= "login = \"".$data["login"]."\"";
        }

        $changeString = "";

        $curLine = 1;
        foreach($changeStrings as $line)
        {
            $changeString .= $line;
            if($curLine != count($changeStrings))
            {
                $changeString .= ",";
            }
        }
        */

        $query = "
            UPDATE ".$this->tableName."
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

    public function delete($id)
    {
        $query = "
            DELETE FROM ".$this->tableName."
            WHERE user_id=".$id.";
        ";
        DBAdapter::execSQL($query);
    }
}