<?php

namespace App\Controllers;

use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
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

        $questionText = $request->get('question_text');
        if ($questionText) {
            $question = new Question();
            $question->setSurveyId($survey->getId());
            $question->setQuestionText($questionText);
            $question->create();
        }
    }
}

