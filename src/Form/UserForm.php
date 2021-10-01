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
        $this->add("cbox", "active", "ACTIVE", null, function($v){return true;});

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