<?php

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class RegistrationController
{
    public function showRegistrationForm(RouteCollection $routes, ?Request $request): void
    {
        require_once APP_ROOT . '/views/registration.php';
    }

    public function register(RouteCollection $routes, Request $request): void
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);

        $user->save();
    }
}
