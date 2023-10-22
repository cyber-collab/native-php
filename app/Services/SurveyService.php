<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;

class SurveyService
{
    public function processSurveyData(int $id, string $title, string $status, array $questionData, array $answerData): void
    {
        $survey = Survey::getById($id);

        if ($survey) {
            $survey->setTitle($title);
            $survey->setStatus($status);
            $survey->update();

            $this->editProcessQuestions($id, $questionData);
            $this->editProcessAnswers($answerData);
        }
    }

    private function editProcessQuestions(int $surveyId, array $questionData): void
    {
        foreach ($questionData as $questionId => $questionText) {
            if ($questionId === 'new') {
                $newQuestion = new Question();
                $newQuestion->setQuestionText($questionText);
                $newQuestion->setSurveyId($surveyId);
                $newQuestion->create();
            } else {
                $question = Question::getById($questionId);
                if ($question) {
                    $question->setQuestionText($questionText);
                    $question->setSurveyId($surveyId);
                    $question->update();
                }
            }
        }
    }

    private function editProcessAnswers(array $answerData): void
    {
        foreach ($answerData as $answerId => $answerText) {
            $answerText = reset($answerText);

            if (str_contains($answerId, 'new')) {
                $questionId = str_replace('new_', '', $answerId);
                $newAnswer = new Answer();
                $newAnswer->setQuestionId($questionId);
                $newAnswer->setAnswerText($answerText);
                $newAnswer->create();
            } else {
                $answers = Answer::getAnswersByQuestionId($answerId);
                foreach ($answers as $answer) {
                    $answer->setAnswerText($answerText);
                    $answer->update();
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

