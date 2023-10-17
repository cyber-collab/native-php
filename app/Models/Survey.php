<?php

namespace App\Models;

use App\Models\Database;
use PDO;
use PDOException;

class Survey
{
    protected int $id;

    protected int $userId;

    protected string $title;

    protected string $status;

    public function create(): void
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO surveys (title, status, user_id) VALUES (:title, :status, :user_id)";
        $params = [
            ':title' => $this->title,
            ':status' => $this->status,
            ':user_id' => $this->userId
        ];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $this->id = $db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public function update(): void
    {
        $db = Database::getInstance();

        $sql = "UPDATE surveys SET title = :title, status = :status WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':title' => $this->title,
            ':status' => $this->status
        ];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public function delete(): void
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM surveys WHERE id = :id";
        $params = [':id' => $this->id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getSurveysByUserId(int $userId): array
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM surveys WHERE user_id = :user_id";
        $params = [':user_id' => $userId];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

}

