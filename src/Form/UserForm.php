<?php

namespace Form;

use Models\UserModel;

class UserForm extends Builder
{
    protected function init()
    {
        //Плохо-код
        $simpleValidate = function ($value) 
        { 
            if (empty($value))
            {
                return false;
            }
            return true;
        };

        $this->add("text", "login", "LOGIN", null, $simpleValidate);
        $this->add("text", "fname", "FNAME", null, $simpleValidate);
        $this->add("text", "lname", "LNAME", null, $simpleValidate);
        $this->add("date", "bday", "BDAY", null, $simpleValidate);
        $this->add("cbox", "active", "ACTIVE", null, $simpleValidate);

        $this->setModel(UserModel::class);
    }

    public function save($data)
    {
        /*if($id == null)
        {
            $this->modelClass::create();
        }*/
    }
}