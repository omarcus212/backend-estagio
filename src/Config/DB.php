<?php

namespace Contatoseguro\TesteBackend\Config;


class DB
{
    public static \PDO $pdo;

    public static function connect()
    {

        $host = $_ENV['MYSQL_HOST'] ?: 'mysql';
        $dbname = $_ENV['MYSQL_DATABASE'] ?: 'contatoseguro';
        $username = $_ENV['MYSQL_USER'] ?: 'root';
        $password = $_ENV['MYSQL_PASSWORD'] ?: '';

        if (empty($host)) {
            throw new \Exception("MYSQL_HOST is not defined in the environment.");
        }

        if (!isset(self::$pdo)) {
            try {

                self::$pdo = new \PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $username,
                    $password,
                    [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                );
            } catch (\PDOException $e) {

                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
