<?php

namespace Form;

use Form\Item\Text;
use Form\Item\Date;
use Form\Item\CBox;
use Form\Item\Image;

class Builder
{
    public const ELEMENTNAME_TEXT = 'text';
    public const ELEMENTNAME_DATE = 'date';
    public const ELEMENTNAME_CBOX = 'cbox';
    public const ELEMENTNAME_IMG  = 'img';


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

            case self::ELEMENTNAME_CBOX:
                $this->elements[] = new Image($name, $default, $label,  $validationFunction);
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
        var_dump("<pre>",$_POST);

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
            die("Try Update");

            $this->model::update($id, $data);
            return true;
        }
        return false;
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