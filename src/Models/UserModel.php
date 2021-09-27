<?php

namespace Models;

use Models\Model;

class UserModel extends Model
{
    public const SAVEPATH = "./data/users/";

    public static function getActiveStatus($data)
    {
        return ("" == $data) ?
            "No":
            "Yes";
    }
}