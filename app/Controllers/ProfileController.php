<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class ProfileController
{
    public function showProfileForm(RouteCollection $routes, ?Request $request): void
    {
        $currentUser = User::getCurrentUser();

        if ($currentUser !== null) {
            require_once APP_ROOT . '/views/profile.php';
        } else {
            echo "User not authenticated";
        }
    }

    public function listSurveys(RouteCollection $routes, ?Request $request): void
    {
        $currentUser = User::getCurrentUser();

        $surveys = Survey::getSurveysByUserId($currentUser->getId());

        foreach ($surveys as $survey) {
            $survey->questions = Question::getQuestionsBySurveyId($survey->getId());

            foreach ($survey->questions as $question) {
                $question->options = Answer::getAnswersByQuestionId($question->getId());
            }
        }

        require_once APP_ROOT . '/views/list_surveys.php';
    }

    public function recordVote(RouteCollection $routes, Request $request): void
    {
        $questionId = (int) $request->get('question_id');
        $answerId = (int) $request->get('answer_id');

        $question = Question::getById($questionId);
        $answer = Answer::getById($answerId);

        if ($question === null || $answer === null) {
            echo "Invalid question or answer";
        }

        $success = Answer::recordVote($questionId, $answerId);

        if ($success) {
            echo "Vote recorded successfully!";
        } else {
            echo "Error recording vote";
        }
    }

    public function logout(RouteCollection $routes, ?Request $request): void
    {
       User::logout();

       echo "You have been logged out.";
    }
}
