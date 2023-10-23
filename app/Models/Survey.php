<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Exceptions\NotFoundObjectException;
use App\Helpers\DatabaseHelper;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class Survey
{
    protected ?int $id = null;

    protected int $userId;

    protected string $title;

    protected string $status;

    protected ?string $question;

    protected string $created_at;

    public function create(): void
    {
        $sql = "INSERT INTO surveys (title, status, user_id, created_at) VALUES (:title, :status, :user_id, NOW())";
        $params = [
            ':title' => $this->title,
            ':status' => $this->status,
            ':user_id' => $this->userId
        ];

        DatabaseHelper::executeQuery($sql, $params);

        $this->id = Database::getInstance()->getConnection()->lastInsertId();
    }

    public function update(): void
    {
        $sql = "UPDATE surveys SET title = :title, status = :status WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':title' => $this->title,
            ':status' => $this->status
        ];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public function delete(): void
    {
        $sql = "DELETE FROM surveys WHERE id = :id";
        $params = [':id' => $this->id];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public static function getSurveysByUserId(int $userId): array
    {
        $sql = "SELECT * FROM surveys WHERE user_id = :userId";
        $params = [':userId' => $userId];

        return DatabaseHelper::executeFetchAll($sql, $params, 'App\Models\Survey');
    }

    /**
     * @throws NotFoundObjectException
     */
    public static function getById(int $id): ?Survey
    {
        $sql = "SELECT * FROM surveys WHERE id = :id";
        $params = [':id' => $id];

        $result = DatabaseHelper::executeFetchObject($sql, $params, 'App\Models\Survey');

        return $result ?? throw new NotFoundObjectException();
    }

    public static function getAllSurveys(): ?array
    {
        $sql = "SELECT * FROM surveys WHERE status = 'published'";

        return DatabaseHelper::executeFetchAll($sql, null, 'App\Models\Survey');
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
