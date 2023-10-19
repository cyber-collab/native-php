<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Models\Database;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class Question
{
    public int $id;

    protected int $surveyId;

    protected string $questionText;


    public ?array $options = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    /**
     * @return int
     */
    public function getSurveyId(): int
    {
        return $this->surveyId;
    }

    /**
     * @param string $questionText
     */
    public function setQuestionText(string $questionText): void
    {
        $this->questionText = $questionText;
    }

    /**
     * @param int $surveyId
     */
    public function setSurveyId(int $surveyId): void
    {
        $this->surveyId = $surveyId;
    }

    public function create(): void
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO questions (survey_id, question_text) VALUES (:survey_id, :question_text)";
        $params = [
            ':survey_id' => $this->surveyId,
            ':question_text' => $this->questionText
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

        $sql = "UPDATE questions SET survey_id = :survey_id, question_text = :question_text WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':survey_id' => $this->surveyId,
            ':question_text' => $this->questionText
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

        $sql = "DELETE FROM questions WHERE id = :id";
        $params = [':id' => $this->id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getQuestionsBySurveyId(int $surveyId): array
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM questions WHERE survey_id = :survey_id";
        $params = [':survey_id' => $surveyId];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_CLASS, 'App\Models\Question');
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public static function getById(int $id): ?Question
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM questions WHERE id = :id";
        $params = [':id' => $id];

        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute($params);

            $result = $stmt->fetchObject('App\Models\Question');

            return ($result !== false) ? $result : null;
        } catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        }
    }

    public function getAnswers(): array {
        return Answer::getAnswersByQuestionId($this->getId());
    }
}
