<?php

namespace Services\Database;

class SLDatabase
{
    private $servername = 'sopnolikhi.com';
    private $database_user = 'toufikhasan_user_bmf';
    private $database_password = 'cj1[PXft,0w0';
    private $database_name = 'toufikhasan_sl_bmf';

    protected function connect(): \PDO | \Exception
    {
        try {
            $database_dsn = "mysql:host={$this->servername};dbname={$this->database_name};charset=utf8";

            $pdo = new \PDO($database_dsn, $this->database_user, $this->database_password, [
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::ATTR_STRINGIFY_FETCHES => false
            ]);

            return $pdo;

        } catch (\PDOException $exception) {

            return $exception;
            die();
        }
    }
}