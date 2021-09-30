<?php

namespace Form\Item;

use Core\Router;

class AbstractItem {
    protected $value;
    protected $name;
    protected $validationFunction;
    protected $template = '';
    
    public function __construct($name, $default = null, $label = null,  $validationFunction = null) 
    {
        $this->name = $name;
        $this->validationFunction = $validationFunction;
    }

    public function isValid()
    {
        if(isset($_POST[$this->name]))
        {
            $this->value = $_POST[$this->name];
        }

        $f = $this->validationFunction;
        if($f)
        {
            return $f($this->getValue());
        }
        return true;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        $this->value = Router::getInstance()->getVar($this->name);
        return $this->value;
    }

    public function render()
    {
        require("Views/form/" . $this->template . ".php");
    }
}