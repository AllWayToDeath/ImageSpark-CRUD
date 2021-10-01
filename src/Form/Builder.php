<?php

namespace Form;

use Form\Item\Text;
use Form\Item\Date;
use Form\Item\CBox;

class Builder
{
    public const ELEMENTNAME_TEXT = 'text';
    public const ELEMENTNAME_DATE = 'date';
    public const ELEMENTNAME_CBOX = 'cbox';
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
            case self::ELEMENTNAME_TEXT:
                $this->elements[] = new Text($name, $default, $label,  $validationFunction);
                break;

            case self::ELEMENTNAME_DATE:
                $this->elements[] = new Date($name, $default, $label,  $validationFunction);
                break;
                
            case self::ELEMENTNAME_CBOX:
                $this->elements[] = new CBox($name, $default, $label,  $validationFunction);
                break;
        }
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
        foreach($this->elements as $element)
        {
            $elementName = $element->getName();
            if(isset($data[$elementName]))
            {
                $value = $data[$elementName];
                $element->setValue($value);
            }
        }
    }

    public function isSubmitted()
    {
        //return !!count($_POST);
        return isset($_POST["submit"]);
    }

    public function isValid()
    {
        $validStatus = true;
        foreach ($this->elements as $element)
        {
            if (!$element->isValid())
            {
                $validStatus = false;
            }
        }
        return $validStatus;
    }

    protected $actionPath;
    protected $backPath;

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