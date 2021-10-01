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
        $this->add(self::ELEMENTNAME_TEXT, "fname", "FNAME", null, [$simpleValidate]);
        $this->add(self::ELEMENTNAME_TEXT, "lname", "LNAME", null, [$simpleValidate]);
        $this->add(self::ELEMENTNAME_DATE, "bday", "BDAY", null, [$simpleValidate]);
        $this->add(self::ELEMENTNAME_CBOX, "active", "ACTIVE", null, [function($v){return true;}]);

        $this->setModel(UserModel::class);
    }

    protected $actionPath = "/edit/user";
    protected $backPath = "/users";

    public function save($id = null)
    {
        $data = array();

        foreach($this->elements as $item)
        {   
            $name  = $item->getName();
            $value = $item->getValue();

            $data[$name] = $value;
        }

        if($id == null or $id == 0)
        {
            die("Try Create");

            $this->model::create($data);
            return true;
        }
        if($this->isSubmitted())
        {   
            $this->model::update($id, $data);
            return true;
        }
        return false;
    }
}