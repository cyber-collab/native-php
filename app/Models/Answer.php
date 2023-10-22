<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Models\Database;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class Answer
{
    protected int $id;

    protected int $questionId;

    protected string $answerText;

    protected int $votes;

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function setAnswerText(string $answerText): self
    {
        $this->answerText = $answerText;
        return $this;
    }

    public function getAnswerText(): string
    {
        return $this->answerText;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }


    public function setVotes(int $votes): void
    {
        $this->votes = $votes;
    }

    public function setQuestionId(int $questionId): self
    {
        $this->questionId = $questionId;
        return $this;
    }
    public function create(): void
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO answers (question_id, answer_text) VALUES (:question_id,  :answer_text)";
        $params = [
            ':question_id' => $this->questionId,
            ':answer_text' => $this->answerText
        ];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $this->id = $db->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public function delete(): void
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM answers WHERE id = :id";
        $params = [':id' => $this->id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public function update(): void
    {
        $db = Database::getInstance();

        $sql = "UPDATE answers SET answer_text = :answer_text WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':answer_text' => $this->answerText,
        ];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getAnswersByQuestionId(int $questionId): array
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM answers WHERE question_id = :question_id";
        $params = [':question_id' => $questionId];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_CLASS, 'App\Models\Answer');
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function recordVote(int $questionId, int $answerId): bool
    {
        $db = Database::getInstance();

        $sql = "UPDATE answers SET votes = votes + 1 WHERE id = :answer_id AND question_id = :question_id";
        $params = [':answer_id' => $answerId, ':question_id' => $questionId];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getById(int $id): ?Answer {
        $db = Database::getInstance();

        $sql = "SELECT * FROM answers WHERE id = :id";
        $params = [':id' => $id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $result = $stmt->fetchObject('App\Models\Answer');

            return ($result !== false) ? $result : null;
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }
}
