<?php
namespace src;
class Singleton
{
    private static $instance = null;

    public static function getInstance(): Singleton
    {
        if(static::$instance === null)
        {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
    }
}