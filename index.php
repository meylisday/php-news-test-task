<?php

use App\Core\Router;

require './vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);

define('ASSET_ROOT',
    'http://' . $_SERVER['HTTP_HOST'] .
    str_replace(
        $_SERVER['DOCUMENT_ROOT'],
        '',
        str_replace('\\', '/', dirname(__DIR__) . '/public')
    )
);

$router = new Router();

$router->add('', ['controller' => 'UserController', 'action' => 'login']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);