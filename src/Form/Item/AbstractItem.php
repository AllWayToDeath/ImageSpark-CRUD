<?php

namespace Form\Item;

use Core\Router;

class AbstractItem {
    protected $value;
    protected $name;
    protected $validationFunction = array();
    protected $template = '';
    protected $errors = array();
    
    public function __construct($name, $default = null, $label = null,  $validationFunction = null) 
    {
        $this->name = $name;
        $this->validationFunction = $validationFunction;
    }

    public function isValid()
    {
        if(isset($_POST[$this->name]))
        {
            $this->setValue($_POST[$this->name]);
        }

        foreach($this->validationFunction as $func)
        {
            if(!$func) 
            {
                continue;
            }

            $error = $func($this->getValue(), $this->getName());
            if($error != null)
            {
                $this->errors []= $error;
            }
        }

        return !count($this->errors);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        //$this->setValue(Router::getInstance()->getVar($this->name));
        return $this->value;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function render()
    {
        require("Views/form/" . $this->template . ".php");
    }
}