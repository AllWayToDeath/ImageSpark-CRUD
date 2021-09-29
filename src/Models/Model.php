<?php

namespace Models;

class Model
{
    protected $id;
    protected $data;
    public const IDINFONAME = "idinfo.txt";
    public const SAVEPATH = "./data/";

    public function save($id = null)
    {
        if($id == null)
        {
            $id = $this->id;
        }
        $fullPath = static::SAVEPATH . "$id.json";
        $jsonData = json_encode($this->data);
        file_put_contents($fullPath, $jsonData);

        if($id > static::getLastJsonID())
        {
            file_put_contents(static::SAVEPATH.self::IDINFONAME, $id);
        }
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
            if(!static::isJSON($fileName))
               continue;
            
            $id = static::deleteExtensionJSON($fileName);
            $data = static::getLoadDataFromJSON($id, static::SAVEPATH);
            $data["id"] = $id;
            $dataList []= $data;
        }
        return $dataList;
    }

    public function loadAndGetData($id)
    {
        $dataIsLoaded = $this->loadDataFromJSON($id);
        $result = null;

        if($dataIsLoaded)
        {
            $result = $this->getData();
        }

        return $result;
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

    public static function getLastJsonID()
    {
        $path = static::SAVEPATH.static::IDINFONAME;
        if(!file_exists($path))
        {
            static::createIdInfo();
        }
        $last_id = file_get_contents($path);
        return $last_id;
    }

    protected static function deleteExtensionJSON(string $file)
    {
        //analog 'str_replace'
        $len = strlen($file);
        return substr($file, 0, $len-5);
    }

    protected static function isJSON($path)
    {
        if (is_dir($path))
            return false;
    
        $is_json = false;
        $ext = substr($path, -5);
        if (".json" == $ext) {
            $is_json = true;
        }
        return $is_json;
    }

    protected static function createIdInfo()
    {
        $last_id = 0;
        $full_path = static::SAVEPATH . static::IDINFONAME;
        //var_dump($full_path);
        file_put_contents($full_path, $last_id);
    }
}