<?php

namespace App\Helpers;

use AllowDynamicProperties;
use App\Models\Database;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class DatabaseHelper
{
    public static function executeQuery(string $sql, array $params, ?int &$id = null): void
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            if ($id !== null) {
                $id = $db->getConnection()->lastInsertId();
            }
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function executeFetchAll(string $sql, ?array $params, string $className): array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_CLASS, $className);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function executeFetchObject(string $sql, array $params, ?string $className): ?object
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $result = $stmt->fetchObject($className);

            return ($result !== false) ? $result : null;
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
}
