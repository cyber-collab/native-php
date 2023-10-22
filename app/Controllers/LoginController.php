<?php

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class LoginController
{
    public function showLoginForm(RouteCollection $routes, ?Request $request): void
    {
        require_once APP_ROOT . '/views/login.php';
    }

    public function authenticate(RouteCollection $routes, ?Request $request): void
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = User::getUserByEmail($email);

        if ($user !== null && $user->validatePassword($password)) {
            session_start();
            $_SESSION['user_id'] = $user->getId();
            header('Location: /profile');
            exit;
        } else {
            echo "Invalid data";
        }
    }
}
