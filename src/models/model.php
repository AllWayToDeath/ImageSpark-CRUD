<?php

require_once "functions.php";

const IDINFONAME = "idinfo.txt";

class Model
{
    protected $id;
    protected $data;
    protected const SAVEPATH = "./data/";

    public function save($id = null)
    {
        $jsonData = json_encode($this->data);

        $nextID = $id;

        if(null == $id)
        {
            $nextID = 1 + getLastJsonID($this->SAVEPATH);
        }

        $fullPath = $this->SAVEPATH . "$nextID.json";
        file_put_contents($this->SAVEPATH.IDINFONAME, $nextID);
        file_put_contents($fullPath, $jsonData);
    }

    public function loadDataFromJSON($id)
    {
        $result = false;
        var_dump("UM path = ", $this->SAVEPATH);//PAth = 0
        $data = $this->getLoadDataFromJSON($id, $this->SAVEPATH);
        var_dump("UM Data = ", $data);
        //var_dump($_GET["id"]);

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
        return self::getAllInFolder(self::SAVEPATH);
    }

    protected static function getAllInFolder($folder)
    {
        $dataList = array();

        foreach(scandir($folder) as $fileName)
        {
            if(!isJSON($fileName))
               continue;
            
            $id = deleteExtensionJSON($fileName);
            $data = self::getLoadDataFromJSON($id, $folder);
            $data["id"] = $id;
            $dataList []= $data;
        }
        return $dataList;
    }

    // Bug!: В потомках вызывается этот же метод, но с родительским путем
    /*
    Все дело в self. Метод вызывается без изменений, 
    т.к. в дочерних классах данный метод не переопределяется
    */
    public static function deleteByID($id)
    {
        if(null == $id)
            return false;

        $fileName = $id.".json";
        $successDelete = unlink(self::SAVEPATH.$fileName);

        return $successDelete;    
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