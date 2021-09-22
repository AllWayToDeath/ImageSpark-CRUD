<?php

require_once "../models/model.php";
require_once "../view.php";

class Controller
{
    protected $ways = array(
        "/notFound"
        ,
    );

    public function treatmentOuterWay(string $newWay)
    {

        /*
        А должен ли контроллер обрабатывать строки?\

        - Нет, ведь он всего лишь посредник. И все данные передает в Model,
            которая делает всю обработку и возвращает уже готовый вариант для View
        - Да, ведь Model отвечает только за обработку логики, а не маршрутизацию
        */

        foreach($this->ways as $way)
        {

        }
    }
}