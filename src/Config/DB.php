<?php

namespace Contatoseguro\TesteBackend\Config;

class DB
{
    public static \PDO $pdo;

    public static function connect()
    {

        $host = $_ENV['DB_HOST'] ?? 'estagio-teste-backend-mysql';
        $dbname = $_ENV['DB_NAME'] ?? 'teste_backend_estagio';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? 'marcus13';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            if (!isset(self::$pdo)) {
                self::$pdo = new \PDO($dsn, $user, $pass);
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            echo "Erro ao conectar: " . $e->getMessage();
            exit;
        }

        return self::$pdo;
    }
}