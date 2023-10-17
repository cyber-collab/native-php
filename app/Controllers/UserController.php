<?php

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\Routing\RouteCollection;

class UserController
{
    public function showAction(int $id, RouteCollection $routes): void
    {
        $user = new User();
        $user->read($id);

        require_once APP_ROOT . '/views/user.php';
	}
}
