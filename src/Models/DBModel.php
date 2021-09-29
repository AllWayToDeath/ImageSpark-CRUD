<?php
namespace Models;

use Core\DBAdapter;

class DBModel
{
    protected static $tableName = "default";
    protected static $idName = "default_id";

    protected $data;

    public function __construct()
    {

    }

    public static function getByID($id)
    {
        $query = "
            SELECT *
            FROM ".static::$tableName."
            WHERE ".static::$idName."=".$id."
        ";
        $result = DBAdapter::execSQL($query);
        
        if(!$result)
        {
            return null;
        }
        return mysqli_fetch_array($result);
    }
    public static function getAll():array
    {
        $query = "
            SELECT *
            FROM ".static::$tableName."
        ";

        $resultSQL = DBAdapter::execSQL($query);
        
        if($resultSQL == false)
        {
            return null;
        }
        $dataList = array();
        $numRows = mysqli_num_rows($resultSQL);

        for($i = 0; $i < $numRows; $i++)
        {
            $dataList []= mysqli_fetch_array($resultSQL);
        }
        return $dataList;
    }
    
    public static function create($data)
    {
        $sqlData = static::convertDataToSQLData($data);
        /*TODO: Переделать с использованием подготовленных запросов*/
        $dynamicQueryPart = static::getQueryPartForCreate($sqlData);

        $query = "
            INSERT INTO ".self::$tableName."
            (".$dynamicQueryPart["fields"].")
            VALUES
            (".$dynamicQueryPart["values"].")
        ";
        DBAdapter::execSQL($query);
    }
    public static function update($id, $data)
    {
        $sqlData = static::convertDataToSQLData($data);
        $dynamicQueryPart = static::getQueryPartForUpdate($sqlData);

        $sqlBody = "";
        foreach($dynamicQueryPart as $pair)
        {
            $sqlBody .= $pair["field"]."=".$pair["value"].",";
        }

        $sqlBody = substr($sqlBody, 0, strlen($sqlBody) - 1);

        $query = "
            UPDATE ".static::$tableName."
            SET
            ".$sqlBody."
            WHERE user_id = ".$id.";
        ";
        DBAdapter::execSQL($query);
    }
    public static function delete($id)
    {
        $query = "
            DELETE FROM ".static::$tableName."
            WHERE ".static::$idName."=".$id.";
        ";
        DBAdapter::execSQL($query);
    }

    /*Пошла мини-жара*/
    /*Формат data: array(["key", "'value'"], ["key", "value"]... )*/
    protected static function getQueryPartForCreate($data)
    {
        $result = array(
            "fields" => "",
            "values" => ""
        );

        $curPairNum = 1;
        foreach($data as $item)
        {
            $result["fields"] .= $item[0];
            $result["values"] .= $item[1];

            if($curPairNum != count($data))
            {
                $result["fields"] .= ", ";
                $result["values"] .= ", ";
            }
            $curPairNum++;
        }
        return $result;
    }
    protected static function getQueryPartForUpdate($data)
    {
        $result = array();

        foreach($data as $item)
        {
            $pair = array();

            $pair["field"] = $item[0];
            $pair["value"] = $item[1];

            $result []= $pair;
        }

        return $result;
    }

    public static function convertDataToSQLData($data)
    {
        return $data;
    }
    public static function convertDateToSQLDate($date)
    {
        extract($date);
        $sqlDate = "$year-$month-$day";
        return $sqlDate;
    }
}