<?php

namespace App\Controllers;

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
}
