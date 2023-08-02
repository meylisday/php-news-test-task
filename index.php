<?php

use App\Controllers\NewsController;
use App\Controllers\UserController;
use App\Core\Router\Exception\MethodNotAllowed;
use App\Core\Router\Exception\RouteNotFound;
use App\Core\Router\Route;
use App\Core\Router\Router;

require './vendor/autoload.php';

error_reporting(E_ALL);

$routes = [
    new Route('index', '/', [UserController::class, 'index']),
    new Route('login', '/login', [UserController::class, 'login'], ['POST']),
    new Route('news', '/news', [NewsController::class, 'index']),
    new Route('create-news', '/create-news', [NewsController::class, 'create'], ['POST']),
    new Route('news-delete', '/news/delete/{id}', [NewsController::class, 'delete']),
    new Route('logout', '/logout', [UserController::class, 'logout']),
];
$router = new Router($routes, 'http://localhost:8000');

try {
    $route = $router->matchFromPath($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


    $handler = $route->getHandler();
    $attributes = $route->getAttributes();

    $controllerName = $handler[0];
    $methodName = $handler[1] ?? null;

    $controller = new $controllerName($attributes);
    if (!is_callable($controller)) {
        $controller = [$controller, $methodName];
    }

    echo $controller(...array_values($attributes));

} catch (MethodNotAllowed $exception) {
    header("HTTP/1.0 405 Method Not Allowed");
    exit();
} catch (RouteNotFound $exception) {
    header("HTTP/1.0 404 Not Found");
    exit();
}