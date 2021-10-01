<?php

namespace Form;

use Models\UserModel;

class UserForm extends Builder
{
    protected function init()
    {
        //Плохо-код
        $simpleValidate = function ($value, $name) 
        { 
            if (empty($value))
            {
                return "$name is empty";
            }
            return null;
        };
        $validateFiveSymbolMore = function ($value, $name) 
        { 
            $lenLimit = 5;
            if (strlen($value) < $lenLimit)
            {
                return "$name has few $lenLimit symbols";
            }
            return null;
        };

        $this->add(self::ELEMENTNAME_TEXT, "login", "LOGIN", null, [$simpleValidate, $validateFiveSymbolMore]);
        // $this->add(self::ELEMENTNAME_TEXT, "fname", "FNAME", null, [$simpleValidate]);
        // $this->add(self::ELEMENTNAME_TEXT, "lname", "LNAME", null, [$simpleValidate]);
        // $this->add(self::ELEMENTNAME_DATE, "bday", "BDAY", null, [$simpleValidate]);
        // $this->add(self::ELEMENTNAME_CBOX, "active", "ACTIVE", null, [function($v){return true;}]);
        $this->add(self::ELEMENTNAME_IMG, "image", "IMG", null, [function($v){return null;}]);


        //$this->setModel(UserModel::class);
    }

    protected $actionPath = "/edit/user";
    protected $backPath = "/users";
}