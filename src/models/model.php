<?php

require_once "functions.php";

const IDINFONAME = "idinfo.txt";

class Model
{
    //protected $id;
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
        $data = $this->getLoadDataFromJSON($id, $this->SAVEPATH);

        if(null != $data)
        {
            $this->data = $data;
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

        foreach(scandir(self::SAVEPATH) as $fileName)
        {
            if(!isJSON($fileName))
               continue;
            
            $id = deleteExtensionJSON($fileName);
            $dataList []= self::getLoadDataFromJSON($id, self::SAVEPATH);
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
}