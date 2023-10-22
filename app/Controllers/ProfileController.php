<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use App\Services\SurveyService;
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

        SurveyService::processSurveys($surveys);

        require_once APP_ROOT . '/views/list_surveys.php';
    }

    public function logout(RouteCollection $routes, ?Request $request): void
    {
       User::logout();

       echo "You have been logged out.";
    }
}
