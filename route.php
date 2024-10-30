<?php

require_once './app/gamesController.php';

require_once './libs/router.php';
require_once './config/config.php';
require_once './libs/response.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/api');

$router = new router();

//router->addRoute(endPoint, CRUD, controller, method);

$router->addRoute('juegos', 'GET', 'gamesController', 'getGames');
$router->addRoute('juegos/:id', 'GET', 'gamesController', 'getGames');
$router->addRoute('juegos/:id', 'DELETE', 'gamesController', 'deleteGame');
$router->addRoute('juegos/:id', 'UPDATE', 'gamesController', 'updateGame');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);