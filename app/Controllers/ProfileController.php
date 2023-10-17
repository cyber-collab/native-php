<?php

namespace App\Controllers;

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
            echo "Пользователь не аутентифицирован";
        }
    }

    public function listSurveys(RouteCollection $routes, ?Request $request): void
    {
        $currentUser = User::getCurrentUser();

        $surveys = Survey::getSurveysByUserId($currentUser->getId());

        require_once APP_ROOT . '/views/list_surveys.php';
    }

}
