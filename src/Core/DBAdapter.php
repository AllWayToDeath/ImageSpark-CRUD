<?php
namespace Core;

class DBAdapter extends Singleton
{
    protected $connection = null;

    protected $host = "db";
    protected $user = "root";
    protected $pswd = "root";
    protected $base = "myapp";

    protected function __construct()
    {
        $this->connection = mysqli_connect(
            $this->host,
            $this->user,
            $this->pswd,
            $this->base
        );
        if (!$this->connection) {
            die("Ошибка соединения");
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public static function execSQL(string $sql)
    {
        $instance = self::getInstance();
        $connection = $instance->DBAdapter::getConnection();
        
        $result = mysqli_query($connection, $sql);
        return $result;
    }
}