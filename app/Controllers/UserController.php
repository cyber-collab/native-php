<?php

namespace App\Controllers;

use App\Models\User;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class UserController
{
    #[NoReturn] public function update(RouteCollection $routes, Request $request, int $id): void
    {
        $user = User::getCurrentUser() ;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['name'];
            $email = $_POST['email'];

            $user->setName($username);
            $user->setEmail($email);

            $user->update();
        }

        header("Location: /profile");
        exit();
    }

}
