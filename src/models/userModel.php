<?php

require_once "model.php";

class UserModel extends Model
{
    protected const SAVEPATH = "./data/users/";

    public static function getAll()
    {
        return self::getAllInFolder(self::SAVEPATH);
    }
}