<?php

require_once "functions.php";

class Model
{
    protected $id;
    protected $data;
    protected const IDINFONAME = "idinfo.txt";
    protected const SAVEPATH = "./data/";

    public function save($id = null)
    {
        $jsonData = json_encode($this->data);

        if(null == $id)
        {
            $id = $this->id;
        }

        $fullPath = static::SAVEPATH . "$id.json";
        file_put_contents(static::SAVEPATH.self::IDINFONAME, $id);
        file_put_contents($fullPath, $jsonData);
    }

    public function loadDataFromJSON($id)
    {
        $result = false;
        $data = $this->getLoadDataFromJSON($id, static::SAVEPATH);

        if(null != $data)
        {
            $this->data = $data;
            $this->id = $id;
            $result = true;
        }
        return $result;
    }

    protected static function getLoadDataFromJSON($id, $folder)
    {
        if (!is_dir($folder))
            return null;

        $fileName = $folder . $id . ".json";
        $jsonData = file_get_contents($fileName);
        $data = json_decode($jsonData, true);

        return $data;
    }

    public static function getAll()
    {
        $dataList = array();

        foreach(scandir(static::SAVEPATH) as $fileName)
        {
            if(!isJSON($fileName))
               continue;
            
            $id = deleteExtensionJSON($fileName);
            $data = self::getLoadDataFromJSON($id, static::SAVEPATH);
            $data["id"] = $id;
            $dataList []= $data;
        }
        return $dataList;
    }

    public static function deleteByID($id)
    {
        if(null == $id)
            return false;

        $fileName = $id.".json";
        $successDelete = unlink(static::SAVEPATH.$fileName);

        return $successDelete; 
    }

    public function setData($data)
    {
        if(array_key_exists("id", $data))
        {
            $this->id = $data["id"];
        }
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
    public function getID()
    {
        return $this->id;
    }
}