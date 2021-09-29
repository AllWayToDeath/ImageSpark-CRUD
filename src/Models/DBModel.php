<?php
namespace Models;

use Core\DBAdapter;

class DBModel
{
    /*
    protected $tableName = "default";
    protected $idName = "default_id";
    protected $columnsName = array();
    */
    protected static $tableName = "users";
    protected static $idName = "user_id";

    protected $data;

    public function __construct()
    {

    }

    public static function getByID($id)
    {
        $query = "
            SELECT *
            FROM ".static::$tableName."
            WHERE id = ".$id."
        ";
        $result = DBAdapter::execSQL($query);
        
        if(!$result)
        {
            $result = null;
        }
        return $result;
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

        // var_dump($resultSQL);
        // echo "<br>";
        // var_dump(mysqli_fetch_array($resultSQL));


        //Плохо-код (исправить)

        for($i = 0; $i < $numRows; $i++)
        {
            $dataList []= mysqli_fetch_array($resultSQL);
        }

        return $dataList;
    }
    public static function create($data)
    {

    }
    public static function update($id, $data)
    {

    }
    public static function delete($id)
    {

    }

    protected function getSQLColumnsName()
    {
        $sqlColName = "";
        $curId = 1;
        $maxId = count($this->columnsName);

        foreach($this->columnsName as $item)
        {
            //var_dump($item);

            $sqlColName .= (string)$item.
            ($curId != $maxId) ? "," : "";
            $curId++;
        }
        return $sqlColName;
    }
}