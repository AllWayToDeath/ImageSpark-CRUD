<?php

namespace src;

require_once "../functions.php";

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
        if (!is_dir($this->SAVEPATH))
            return false;

        $fileName = $this->SAVEPATH . $id . ".json";
        $jsonData = file_get_contents($fileName);
        $this->data = json_decode($jsonData, true);

        return true;
    }
}