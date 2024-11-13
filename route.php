<?php

require_once './app/controllers/gamesController.php';

require_once './libs/router.php';
require_once './config/config.php';
require_once './libs/response.php';
require_once './app/middlewares/jwtAuth.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/api');

$router = new router();

$router->addMiddleware(new JWTAuthMiddleware());

//router->addRoute(endPoint, CRUD, controller, method);

//rutas sobre un CRUD basico en la tabla juegos
$router->addRoute('juegos', 'GET', 'gamesController', 'getGames');
$router->addRoute('juegos/:id', 'GET', 'gamesController', 'getGames');
$router->addRoute('juegos/:id', 'DELETE', 'gamesController', 'deleteGame');
$router->addRoute('juegos', 'POST', 'gamesController', 'createGame');
$router->addRoute('juegos/:id', 'PUT', 'gamesController', 'updateGame');

//ruta sobre el token usando API-auth
$router->addRoute('usuarios/token', 'GET', 'authController', 'getToken');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);