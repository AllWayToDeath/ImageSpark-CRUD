<?php

namespace Controllers;

use Controllers\Controller;
use Core\Router;

abstract class DataController extends Controller
{
    abstract protected static function create();
    abstract protected static function edit($id);
    abstract protected static function trySave($id);

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

    protected static function validateDate($date)
    {
        extract($date);

        $errors = array();

        //Day
        if($day == null)
        {
            $errors []= "Day is empty";
        }

        //Month
        if($month == null)
        {
            $errors []= "Month is empty";
        }
        
        //Year
        if($year == null)
        {
            $errors []= "Year is empty";
        }
        
        //add other logic here ...

        return $errors;
    }
}