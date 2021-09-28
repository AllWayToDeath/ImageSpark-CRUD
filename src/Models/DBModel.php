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
    protected $tableName = "users";
    protected $idName = "user_id";

    protected $data;

    public function __construct()
    {

    }

    public function getByID($id)
    {
        $query = "
            SELECT *
            FROM ".$this->tableName."
            WHERE id = ".$this->idName."
        ";
        //$result = <...>execSQL($query);
    }
    public function list():array
    {
        $query = "
            SELECT *
            FROM ".$this->tableName."
        ";

        $resultSQL = DBAdapter::execSQL($query);
        
        if($resultSQL == false)
        {
            return null;
        }
        $dataList = array();

        foreach(mysqli_fetch_array($resultSQL) as $user)
        {
            $dataList []= $user;
        }

        return $dataList;
    }
    public function save($data)
    {

    }
    public function create($data)
    {

    }
    public function update($id, $data)
    {

    }
    public function delete($id)
    {

    }

    protected function getSQLColumnsName()
    {
        $sqlColName = "";
        $curId = 1;
        $maxId = count($this->columnsName);

        foreach($this->columnsName as $item)
        {
            var_dump($item);

            $sqlColName .= (string)$item.
            ($curId != $maxId) ? "," : "";
            $curId++;
        }
        return $sqlColName;
    }
}