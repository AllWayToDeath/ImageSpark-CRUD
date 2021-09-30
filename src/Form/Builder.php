<?php

namespace Form;

use Form\Item\Text;
use Form\Item\Date;
use Form\Item\CBox;

class Builder
{

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        // Тут инициализировать элементы
    }

    protected $elements = [];

    public function add($type, $name, $label, $default = null, $validationFunction = null) {
        
        switch($type)
        {
            case 'text':
                $this->elements[] = new Text($name, $default, $label,  $validationFunction);
                break;
            case 'date':
                $this->elements[] = new Date($name, $default, $label,  $validationFunction);
                break;
            case 'cbox':
                $this->elements[] = new CBox($name, $default, $label,  $validationFunction);
                break;
        }

        /*
        if ($type == 'text')
        {
            $this->elements[] = new Text($name, $default, $label,  $validationFunction );
        }
        */
    }

    protected $model;

    public function setModel($modelClass)
    {
        $this->model = new $modelClass();
    }

    public function loadFromModel($id)
    {
        if($id < 1)
        {
            return;
        }
        $data = $this->model::getByID($id);
        var_dump($data);
        foreach($this->elements as $element)
        {
            $elementName = $element->getName();
            if(isset($data[$elementName]))
            {
                $element->setValue($data[$elementName]);
            }
        }
    }

    public function isSubmitted()
    {
        return !!count($_POST);
    }

    public function isValid()
    {
        foreach ($this->elements as $element)
        {
            if (!$element->isValid())
            {
                return false;
            }
        }
        return true;
    }

    public function render()
    {
        ob_start();
        foreach ($this->elements as $element)
        {
            $element->render();
        }
        $elements = ob_get_clean();

        require "Views/form/form.php";
    }
}