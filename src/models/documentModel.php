<?php

require_once "model.php";

class DocumentModel extends Model
{
    protected const SAVEPATH = "./data/documents/";

    public static function getAll()
    {
        return self::getAllInFolder(self::SAVEPATH);
    }
}