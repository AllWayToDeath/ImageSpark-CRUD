<?php

namespace Controllers;

use Controllers\Controller;
use Core\Router;

abstract class DataController extends Controller
{
    abstract protected static function create();
    abstract protected static function edit($id);

    public function baseEditOrCreate(string $location, string $submitName)
    {
        $result = array();

        //Load
        if(isset($_GET["id"]))
        {
            $result["vararr"] = static::edit($_GET["id"]);
        }
        else
        {
            $result["vararr"] = static::create();
        }

        if(count($_POST) > 0)
        {
            $id = Router::getVar($submitName);
            $temp = static::trySave($id);            
        
            if(count($temp["errors"]) == 0)
            {
                header("location: /".$location);
                return;
            }

            $result["data"] = $temp["data"];
            $result["errors"] = $temp["errors"];
            unset($temp);
        }

        return $result;
    }

    protected static function trySave($id)
    {
        return array(
            "errors" => "",
            "some" => $id
        );
    }
}