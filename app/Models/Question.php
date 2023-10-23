<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Helpers\DatabaseHelper;
use App\Models\Database;
use Exception;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class Question
{
    protected int $id;

    protected int $surveyId;

    protected string $questionText;

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuestionText(): string
    {
        return $this->questionText;
    }

    public function getSurveyId(): int
    {
        return $this->surveyId;
    }

    public function setQuestionText(string $questionText): void
    {
        $this->questionText = $questionText;
    }

    public function setSurveyId(int $surveyId): void
    {
        $this->surveyId = $surveyId;
    }

    public function create(): void
    {
        $sql = "INSERT INTO questions (survey_id, question_text) VALUES (:survey_id, :question_text)";
        $params = [
            ':survey_id' => $this->surveyId,
            ':question_text' => $this->questionText
        ];

        DatabaseHelper::executeQuery($sql, $params);

        $this->id = Database::getInstance()->getConnection()->lastInsertId();

    }

    public function update(): void
    {
        $sql = "UPDATE questions SET survey_id = :survey_id, question_text = :question_text WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':survey_id' => $this->surveyId,
            ':question_text' => $this->questionText
        ];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public function delete(): void
    {
        $sql = "DELETE FROM questions WHERE id = :id";
        $params = [':id' => $this->id];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public static function getQuestionsBySurveyId(int $surveyId): array
    {
        $sql = "SELECT * FROM questions WHERE survey_id = :survey_id";
        $params = [':survey_id' => $surveyId];

        return DatabaseHelper::executeFetchAll($sql, $params, 'App\Models\Question');
    }

    public static function getById(int $id): ?Question
    {
        $sql = "SELECT * FROM questions WHERE id = :id";
        $params = [':id' => $id];

        return DatabaseHelper::executeFetchObject($sql, $params, 'App\Models\Question');
    }

    /**
     * @throws Exception
     */
    public function getAnswers(): array {
        return Answer::getAnswersByQuestionId($this->getId());
    }
}
