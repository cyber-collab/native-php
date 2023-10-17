<?php

namespace App\Controllers;

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

}
