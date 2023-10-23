<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

// Routes system
$routes = new RouteCollection();
$routes->add('homepage', new Route(constant('URL_SUBFOLDER') . '/', ['controller' => 'PageController', 'method'=>'index'], []));
$routes->add('user', new Route(constant('URL_SUBFOLDER') . '/user/{id}', ['controller' => 'UserController', 'method'=>'showAction'], ['id' => '[0-9]+']));
$routes->add('register', new Route(constant('URL_SUBFOLDER') . '/register', ['controller' => 'RegistrationController', 'method'=>'showRegistrationForm'], []));
$routes->add('register_new', new Route(constant('URL_SUBFOLDER') . '/register/new', ['controller' => 'RegistrationController', 'method'=>'register'], []));
$routes->add('profile', new Route(constant('URL_SUBFOLDER') . '/profile', ['controller' => 'ProfileController', 'method'=>'showProfileForm'], []));
$routes->add('login', new Route(constant('URL_SUBFOLDER') . '/login', ['controller' => 'LoginController', 'method'=>'showLoginForm'], []));
$routes->add('login_authenticate', new Route(constant('URL_SUBFOLDER') . '/login/authenticate', ['controller' => 'LoginController', 'method' => 'authenticate'], []));
$routes->add('survey', new Route(constant('URL_SUBFOLDER') . '/survey', ['controller' => 'SurveyController', 'method' => 'createSurveyForm'], []));
$routes->add('survey/new', new Route(constant('URL_SUBFOLDER') . '/survey/new', ['controller' => 'SurveyController', 'method' => 'createSurvey'], []));
$routes->add('list_surveys', new Route(constant('URL_SUBFOLDER') . '/profile/list_surveys', ['controller' => 'ProfileController', 'method' => 'listSurveys'], []));
$routes->add('edit_survey', new Route(constant('URL_SUBFOLDER') . '/survey/edit/{id}', ['controller' => 'SurveyController', 'method' => 'editSurveyForm'], ['id' => '\d+']));
$routes->add('update_survey', new Route(constant('URL_SUBFOLDER') . '/survey/update/{id}', ['controller' => 'SurveyController', 'method' => 'editSurvey'], ['id' => '\d+']));
$routes->add('delete_survey', new Route(constant('URL_SUBFOLDER') . '/survey/delete/{id}', ['controller' => 'SurveyController', 'method' => 'deleteSurvey'], ['id' => '\d+']));
$routes->add('logout', new Route(constant('URL_SUBFOLDER') . '/logout', ['controller' => 'ProfileController', 'method' => 'logout'], []));
$routes->add('record_vote', new Route(constant('URL_SUBFOLDER') . '/record-vote', ['controller' => 'SurveyController', 'method' => 'recordVote'], []));
$routes->add('all_surveys', new Route(constant('URL_SUBFOLDER') . '/all-surveys', ['controller' => 'PageController', 'method' => 'getAllSurveys'], []));
$routes->add('filter_surveys', new Route(constant('URL_SUBFOLDER') . '/filter-surveys', ['controller' => 'SurveyController', 'method' => 'filterSurveys'], []));
$routes->add('update_user', new Route(constant('URL_SUBFOLDER') . '/user/update/{id}', ['controller' => 'UserController', 'method' => 'update'], ['id' => '\d+']));

