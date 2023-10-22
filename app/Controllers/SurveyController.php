<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class SurveyController
{
    public function createSurveyForm(RouteCollection $routes, ?Request $request): void
    {
        require_once APP_ROOT . '/views/create_survey.php';
    }

    public function createSurvey(RouteCollection $routes, Request $request): void
    {
        $title = $request->get('title');
        $status = $request->get('status');
        $currentUser = User::getCurrentUser();

        $survey = new Survey();
        $survey->setUserId($currentUser->getId());

        $survey->setTitle($title);
        $survey->setStatus($status);
        $survey->create();

        $questionTexts = $request->get('question_text');
        $answerTexts = $request->get('answer_text');

        if ($questionTexts && is_array($questionTexts)) {
            foreach ($questionTexts as $questionIndex => $questionText) {
                $question = new Question();
                $question->setSurveyId($survey->getId());
                $question->setQuestionText($questionText);
                $question->create();
                if (isset($answerTexts[$questionIndex])) {
                    foreach ($answerTexts as $answerText) {
                        $answer = new Answer();
                        $answer->setQuestionId($question->getId());
                        $answer->setAnswerText($answerText);
                        $answer->create();
                    }
                }
            }
        }
        header("Location: /profile/list_surveys");
        exit();
    }

    public function editSurveyForm(RouteCollection $routes, ?Request $request, ?int $id): void
    {
        $survey = Survey::getById($id);

        if ($survey) {
            require_once APP_ROOT . '/views/edit_survey.php';
        }
    }

    #[NoReturn] public function editSurvey(RouteCollection $routes, Request $request, ?int $id): void
    {
        $title = $request->get('title');
        $status = $request->get('status');

        $survey = Survey::getById($id);

        if ($survey) {
            $survey->setTitle($title);
            $survey->setStatus($status);
            $survey->update();

            $questionTexts = $request->get('question_text');
            $answerTexts = $request->get('answer_text');

            foreach ($questionTexts as $questionId => $questionText) {
                if ($questionId === 'new') {
                    $newQuestion = new Question();
                    $newQuestion->setQuestionText($questionText);
                    $newQuestion->setSurveyId($id);
                    $newQuestion->create();
                    $questionId = $newQuestion->getId();
                } else {
                    $question = Question::getById($questionId);
                    if ($question) {
                        $question->setQuestionText($questionText);
                        $question->setSurveyId($id);
                        $question->update();
                    }
                }

                if (isset($answerTexts[$questionId]) && is_array($answerTexts[$questionId])) {
                    foreach ($answerTexts[$questionId] as $answerId => $answerText) {
                        if (str_contains($answerId, 'new')) {
                            $newAnswer = new Answer();
                            $newAnswer->setQuestionId($questionId);
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
            $deletedAnswers = $request->get('deleted_answers');
            if (isset($deletedAnswers)) {
                foreach ($deletedAnswers as $deletedAnswerId) {
                    $deletedAnswer = Answer::getById($deletedAnswerId);
                    $deletedAnswer?->delete();
                }
            }
        }
        header("Location: /profile/list_surveys", true, 200);
        exit();
    }

    public function deleteSurvey(RouteCollection $routes, Request $request, int $id): void
    {
        $questions = Question::getQuestionsBySurveyId($id);
        foreach ($questions as $question) {
            $answers = Answer::getAnswersByQuestionId($question->getId());
            foreach ($answers as $answer) {
                $answer->delete();
            }
            $question->delete();
        }

        $survey = Survey::getById($id);

        if ($survey) {
            $survey->delete();

            header("Location: /profile/list_surveys");
            exit();
        }
    }


    public function filterSurveys(RouteCollection $routes, Request $request): void
    {
        $title = $request->get('title');
        $status = $request->get('status');
        $publishedDate = $request->get('created_at');

        $sql = "SELECT * FROM surveys WHERE 1";

        if ($title) {
            $sql .= " AND title LIKE '%$title%'";
        }

        if ($status) {
            $sql .= " AND status = '$status'";
        }

        if ($publishedDate) {
            $sql .= " AND DATE(created_at) = '$publishedDate'";
        }

        $surveys = Survey::getSurveysByCustomQuery($sql);

        foreach ($surveys as $survey) {
            $survey->questions = Question::getQuestionsBySurveyId($survey->getId());

            foreach ($survey->questions as $question) {
                $question->options = Answer::getAnswersByQuestionId($question->getId());
            }
        }

        require_once APP_ROOT . '/views/filtered_surveys.php';
    }

    public function recordVote(RouteCollection $routes, Request $request): void
    {
        $questionId = $request->get('question_id');
        $answerId = $request->get('answer_id');

        $question = Question::getById($questionId);
        $answer = Answer::getById($answerId);

        if ($question === null || $answer === null) {
            echo "Invalid question or answer";
            exit();
        }

        $success = Answer::recordVote($questionId, $answerId);

        if ($success) {
            echo "Vote recorded successfully!";
        } else {
            echo "Error recording vote";
        }
    }
}
