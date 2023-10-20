<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Models\Database;
use DateTime;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class Survey
{
    protected int $id;

    protected int $userId;

    protected string $title;

    protected string $status;

    protected ?string $question;

    protected string $created_at;

    public function create(): void
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO surveys (title, status, user_id, created_at) VALUES (:title, :status, :user_id, NOW())";
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

        $sql = "SELECT * FROM surveys WHERE user_id = :userId";
        $params = [':userId' => $userId];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_CLASS, 'App\\Models\\Survey');
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getById(int $id): ?Survey
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM surveys WHERE id = :id";
        $params = [':id' => $id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $result = $stmt->fetchObject('App\Models\Survey');

            return ($result !== false) ? $result : null;
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getAllSurveys(): ?array
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM surveys WHERE status = 'published'";

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'App\Models\Survey');
            return ($results !== false) ? $results : null;
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

    public function getQuestions(): array {
        return Question::getQuestionsBySurveyId($this->getId());
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public static function getSurveysByCustomQuery($sql): ?array
    {
        $db = Database::getInstance();

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_CLASS, 'App\Models\Survey');
            return ($results !== false) ? $results : null;
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

}
