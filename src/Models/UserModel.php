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

    public function save($data)
    {

    }
    public function create($data)
    {
        $query = "
            INSERT INTO ".$this->tableName."
            (login, first_name, last_name, bday, active)
            VALUES(
                \"".$data["login"]."\",
                \"".$data["first_name"]."\",
                \"".$data["last_name"]."\",
                '".$data["bday"]."',
                ".$data["active"]."
            )
        ";
        
        $inst = DBAdapter::getInstance();
        $conn = $inst->getConnection();
       
        DBAdapter::execSQL($query);

        var_dump(mysqli_error($conn));
        var_dump($query);
    }
}