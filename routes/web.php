<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', ['controller' => 'PageController', 'method'=>'indexAction'], []));
$routes->add('user', new Route(constant('URL_SUBFOLDER') . '/user/{id}', ['controller' => 'UserController', 'method'=>'showAction'], ['id' => '[0-9]+']));
$routes->add('register', new Route(constant('URL_SUBFOLDER') . '/register', ['controller' => 'RegistrationController', 'method'=>'showRegistrationForm'], []));
$routes->add('register/new', new Route(constant('URL_SUBFOLDER') . '/register/new', ['controller' => 'RegistrationController', 'method'=>'register'], []));
$routes->add('profile', new Route(constant('URL_SUBFOLDER') . 'profile', ['controller' => 'ProfileController', 'method'=>'showProfileForm'], []));
$routes->add('login', new Route(constant('URL_SUBFOLDER') . 'login', ['controller' => 'LoginController', 'method'=>'showLoginForm'], []));
$routes->add('login_authenticate', new Route(constant('URL_SUBFOLDER') . '/login/authenticate', ['controller' => 'LoginController', 'method' => 'authenticate'], []));
$routes->add('survey', new Route(constant('URL_SUBFOLDER') . '/survey', ['controller' => 'SurveyController', 'method' => 'createSurveyForm'], []));
$routes->add('survey/new', new Route(constant('URL_SUBFOLDER') . '/survey/new', ['controller' => 'SurveyController', 'method' => 'createSurvey'], []));
$routes->add('create_question', new Route('/question/create', ['controller' => 'QuestionController', 'method' => 'createQuestion'], []));
$routes->add('list_surveys', new Route(constant('URL_SUBFOLDER') . '/profile/list_surveys', ['controller' => 'ProfileController', 'method' => 'listSurveys'], []));
$routes->add('logout', new Route(constant('URL_SUBFOLDER') . 'logout', ['controller' => 'ProfileController', 'method' => 'logout'], []));
