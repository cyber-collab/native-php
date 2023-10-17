<?php

namespace App\Controllers;

use App\Models\Question;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class QuestionController
{
    public function showQuestionForm(RouteCollection $routes, ?Request $request): void
    {
        require_once APP_ROOT . '/views/question_form.php';
    }

    public function createQuestion(RouteCollection $routes, Request $request): void
    {
        $surveyId = $request->get('survey_id');
        $questionText = $request->get('question_text');

        $question = new Question();
        $question->setSurveyId($surveyId);
        $question->setQuestionText($questionText);
        $question->create();

        header('Location: /');
        exit();
    }

    public function editQuestion(RouteCollection $routes, Request $request): void
    {
        $questionId = $request->get('question_id');
        $surveyId = $request->get('survey_id');
        $questionText = $request->get('question_text');

        $question = new Question();
        $question->setId($questionId);
        $question->setSurveyId($surveyId);
        $question->setQuestionText($questionText);
        $question->update();

        header('Location: /');
        exit();
    }

    public function deleteQuestion(RouteCollection $routes, Request $request): void
    {
        $questionId = $request->get('question_id');

        $question = new Question();
        $question->setId($questionId);
        $question->delete();

        header('Location: /');
        exit();
    }
}
