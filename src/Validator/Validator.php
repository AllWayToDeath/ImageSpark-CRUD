<?php

namespace Validator;

class Validator
{
    public static function validateUserData($userData)
    {
        extract($userData);
        $errors = array();   
        
        $erLogin = static::validateLogin($login);
        $erFName = static::validateName($fname, "First");
        $erLName = static::validateName($lname, "Last");
        $erBDay  = static::validateDate($bday);

        $errors = array_merge(
            $erLogin, 
            $erFName, 
            $erLName, 
            $erBDay
        );
        return $errors;
    }

    public static function validateDocumentData($userData)
    {
        extract($userData);

        $errors = array_merge(
            static::validateTitleName($organisation, "Organisation"),
            static::validateTitleName($counteragent, "counteragent"),
            static::validateTitleName($signer, "signer"),
            static::validateDate($dateofcontract["start"]),
            static::validateDate($dateofcontract["finish"]),
            static::validateTitleName($objectofcontract, "objectofcontract"),
            static::validateCurrency($currency),
            static::validateCost($costofcontract),
            static::validateAdress($requisites["adress"]),
            static::validateINN($requisites["inn"]),
            static::validateAccount($requisites["chacc"])
        );
        return $errors;
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

    protected static function validateLogin($login)
    {
        $errors = array();

        //↓↓↓ No ARAB style! ↓↓↓
        if($login == null)
        {
            $errors []= "Login is empty";
        }

        //add other logic here ...

        return $errors;
    }

    protected static function validateName($name, $prefix = "")
    {
        $errors = array();
        $postfix = ($prefix == "") ?
             "Name": "$prefix name";

        if($name == null)
        {
            $errors []= "$postfix is empty";
        }
        if(! preg_match("/^[a-zA-z]*$/", $name))
        {
            $errors []= "$postfix contain a wrong symbol";
        }

        //add other logic here ...

        return $errors;
    }

    protected static function validateTitleName($name, $fieldName)
    {
        $errors = array();

        if($name == null)
        {
            $errors []= "$fieldName is empty";
        }
        //Разрешить цифры и разобраться с регулярными выражениями
        if(! preg_match("/^[a-zA-z]*$/", $name))
        {
            $errors []= "$fieldName contain a wrong symbol";
        }
        return $errors;
    }

    protected static function validateAccount($acc)
    {
        $errors = array();

        if($acc == null)
        {
            $errors []= "Account is empty";
        }

        return $errors;
    }

    protected static function validateCurrency($currency)
    {
        $errors = array();

        if($currency == null)
        {
            $errors []= "Currency is empty";
        }

        return $errors;
    }
    protected static function validateCost($cost)
    {
        $errors = array();

        if($cost == null)
        {
            $errors []= "Cost is empty";
        }
        if(!filter_var($cost, FILTER_VALIDATE_INT))
        {
            $errors []= "Cost is wrong";
        }
        if($cost < 0)
        {
            $errors []= "Cost is low";
        }

        return $errors;
    }

    protected static function validateAdress($adress)
    {
        $errors = array();

        if($adress == null)
        {
            $errors []= "Adress is empty";
        }

        return $errors;
    }
    protected static function validateINN($inn)
    {
        $errors = array();

        if($inn == null)
        {
            $errors []= "INN is empty";
        }
        if(!filter_var($inn, FILTER_VALIDATE_INT))
        {
            $errors []= "INN is wrong";
        }
        if(strlen((string)$inn) != 12)
        {
            $errors []= "INN is wrong";
        }

        return $errors;
    }
}