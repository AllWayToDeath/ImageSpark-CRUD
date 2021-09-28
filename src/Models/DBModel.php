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
    protected $columnsName = array();

    public function __construct()
    {
        $this->columnsName = array(
            $this->idName,
            //"default_column"
            
            "user_id",
            "login",
            "first_name",
            "list_name",
            "bday",
            "active"
            
        );
    }

    public function getByID($id)
    {
        $query = "
            select ".$this->getSQLColumnsName()."
            from ".$this->tableName."
            where id = ".$this->idName."
        ";
        //$result = <...>execSQL($query);
    }
    public function list()//:array
    {
        $dataList = array();

        $query = "
            select ".$this->getSQLColumnsName()."
            from ".$this->tableName."
        ";

        //** @var DBAdapter */
        /*$inst = DBAdapter::getInstance();
        $result = $inst->execSQL($query);
        $dataList = mysqli_fetch_array($result);*/

        $result = DBAdapter::execSQL($query);
        $dataList = null;
        
        if($result != false)
        {
            $dataList = mysqli_fetch_array($result);
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
            $sqlColName .= (string)$item.
            ($curId != $maxId) ? "," : "";
            $curId++;
        }
        return $sqlColName;
    }
}