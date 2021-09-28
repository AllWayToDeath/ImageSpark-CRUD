<?php

namespace Core;

class Singleton
{
    protected static $instance = null;

    public static function getInstance(): Singleton
    {
        if(static::$instance === null)
        {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
    }
}