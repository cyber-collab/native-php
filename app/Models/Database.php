<?php

namespace App\Models;

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct( string $servername, string $username, string $password, string $dbname)
    {
        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): ?Database
    {
        if (self::$instance === null) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '../../../');
            $dotenv->load();

            $servername = $_ENV['DB_SERVER'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];
            $dbname = $_ENV['DB_NAME'];

            self::$instance = new self($servername, $username, $password, $dbname);
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
