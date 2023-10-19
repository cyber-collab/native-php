<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class PageController
{
    // Homepage action
	public function indexAction(RouteCollection $routes, ?Request $request)
	{
        $user = User::getCurrentUser();

        require_once APP_ROOT . '/views/home.php';
	}

    public function getAllSurveys(RouteCollection $routes, ?Request $request): void
    {
        $surveys = Survey::getAllSurveys();

        foreach ($surveys as $survey) {
            $survey->questions = Question::getQuestionsBySurveyId($survey->getId());

            foreach ($survey->questions as $question) {
                $question->options = Answer::getAnswersByQuestionId($question->getId());
            }
        }

        require_once APP_ROOT . '/views/all_surveys.php';
    }

}
