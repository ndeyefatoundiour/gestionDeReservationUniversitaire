<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/View/helpers.php';
require_once dirname(__DIR__) . '/config/database.php';

$container = require_once dirname(__DIR__) . '/config/container.php';

$dispatcher = require_once dirname(__DIR__) . '/routes/web.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.1 404 Not Found");
        $container->get(\App\View\Renderer::class)->render('error/404');
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.1 405 Method Not Allowed");
        
        $allowedMethods = $routeInfo[1]; 
        header('Allow: ' . implode(', ', $allowedMethods));
        
        $container->get(\App\View\Renderer::class)->render('error/405');
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1]; 
        $vars = $routeInfo[2];   

        $controllerClass = $handler[0];
        $method = $handler[1];

        $controller = $container->get($controllerClass);
        
        $controller->$method($vars);
        break;
}
