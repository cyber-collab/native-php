<?php

namespace App\Services;

use App\Exceptions\NotFoundObjectException;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;

class SurveyService
{
    /**
     * @throws NotFoundObjectException
     */
    public function processSurveyData(int $id, string $title, string $status, array $questionData, array $answerData): void
    {
        $survey = Survey::getById($id);

        if ($survey) {
            $survey->setTitle($title);
            $survey->setStatus($status);
            $survey->update();

            $newQuestionIds = $this->editProcessQuestions($id, $questionData);
            $this->editProcessAnswers($newQuestionIds, $answerData);
        }
    }

    private function editProcessQuestions(int $surveyId, array $questionData): array
    {
        $newQuestionIds = [];

        foreach ($questionData as $questionId => $questionText) {
            if (str_starts_with($questionId, 'new_')) {
                $newQuestion = new Question();
                $newQuestion->setQuestionText($questionText);
                $newQuestion->setSurveyId($surveyId);
                $newQuestion->create();
                $newQuestionIds[] = $newQuestion->getId();
            } else {
                $question = Question::getById($questionId);
                if ($question) {
                    $question->setQuestionText($questionText);
                    $question->setSurveyId($surveyId);
                    $question->update();
                }
            }
        }

        return $newQuestionIds;
    }

    /**
     * @throws NotFoundObjectException
     */
    private function editProcessAnswers(array $newQuestionIds, array $answerData): void
    {
        foreach ($answerData as $questionId => $answers) {
            foreach ($answers as $answerId => $answerText) {
                if (str_starts_with($answerId, 'new_')) {
                    $newQuestionId = array_shift($newQuestionIds);
                    $newAnswer = new Answer();
                    $newAnswer->setQuestionId($newQuestionId ?? $questionId);
                    $newAnswer->setAnswerText($answerText);
                    $newAnswer->create();
                } else {
                    $answer = Answer::getById($answerId);
                    if ($answer) {
                        $answer->setAnswerText($answerText);
                        $answer->update();
                    }
                }
            }
        }
    }

    public static function processSurveys(array $surveys): void
    {
        foreach ($surveys as $survey) {
            $survey->questions = Question::getQuestionsBySurveyId($survey->getId());

            foreach ($survey->questions as $question) {
                $question->options = Answer::getAnswersByQuestionId($question->getId());
            }
        }
    }
}

