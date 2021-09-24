<?php

require_once "models/model.php";
require_once "views/view.php";

class Controller
{
    protected static function validateDate($date)
    {
        extract($date);

        $errors = array();

        //Day
        if($day == null)
        {
            $errors []= "Day is empty";
        }
        $options = array(
            'options' => array(
                'default' => 1
                ,'min_range' => 1
                ,'max_range' => 31
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );
        filter_var($day, FILTER_VALIDATE_INT, $options);

        //Month
        if($month == null)
        {
            $errors []= "Month is empty";
        }
        $options = array(
            'options' => array(
                'default' => 1
                ,'min_range' => 1
                ,'max_range' => 12
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );
        filter_var($month, FILTER_VALIDATE_INT, $options);

        //Year
        if($year == null)
        {
            $errors []= "Year is empty";
        }
        $options = array(
            'options' => array(
                'default' => 2021
            ),
            'flags' => FILTER_FLAG_ALLOW_OCTAL,
        );
        filter_var($year, FILTER_VALIDATE_INT, $options);

        //add other logic here ...

        return $errors;
    }
}