<?php
namespace App\Database;

class Mariadb {
    private string $host = "localhost";
    private string $dbname = "my_tarefas";
    private string $username = "root";
    private string $password = "123456";
    private ?\PDO $connection = null;

    public function __construct() {
        try {
            $this->connection = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (\PDOException $erro) {
            die("Erro de conexão: " . $erro->getMessage());
        }
    }

    public function getConnection(): ?\PDO {
        return $this->connection;
    }


}   