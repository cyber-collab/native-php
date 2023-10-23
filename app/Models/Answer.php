<?php

namespace App\Models;

use AllowDynamicProperties;
use App\Exceptions\NotFoundObjectException;
use App\Helpers\DatabaseHelper;

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
        $sql = "INSERT INTO answers (question_id, answer_text) VALUES (:question_id,  :answer_text)";
        $params = [
            ':question_id' => $this->questionId,
            ':answer_text' => $this->answerText
        ];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public function delete(): void
    {
        $sql = "DELETE FROM answers WHERE id = :id";
        $params = [':id' => $this->id];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public function update(): void
    {
        $sql = "UPDATE answers SET answer_text = :answer_text WHERE id = :id";
        $params = [
            ':id' => $this->id,
            ':answer_text' => $this->answerText,
        ];

        DatabaseHelper::executeQuery($sql, $params);
    }

    public static function getAnswersByQuestionId(int $questionId): array
    {
        $sql = "SELECT * FROM answers WHERE question_id = :question_id";
        $params = [':question_id' => $questionId];

        return DatabaseHelper::executeFetchAll($sql, $params, 'App\Models\Answer');
    }

    public static function recordVote(int $questionId, int $answerId): bool
    {
        $sql = "UPDATE answers SET votes = votes + 1 WHERE id = :answer_id AND question_id = :question_id";
        $params = [':answer_id' => $answerId, ':question_id' => $questionId];

        return DatabaseHelper::executeQuery($sql, $params) !== null;
    }

    /**
     * @throws NotFoundObjectException
     */
    public static function getById(int $id): ?Answer
    {
        $sql = "SELECT * FROM answers WHERE id = :id";
        $params = [':id' => $id];

        $result = DatabaseHelper::executeFetchObject($sql, $params, 'App\Models\Answer');

        return $result ?? throw new NotFoundObjectException();
    }
}
