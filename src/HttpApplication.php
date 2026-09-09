<?php

declare(strict_types=1);

namespace App;

use App\View\Renderer;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

final class HttpApplication
{
    public function __construct(
        private readonly Dispatcher $dispatcher,
        private readonly ContainerInterface $container,
    ) {
    }

    public function run(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        if (false !== $position = strpos($uri, '?')) {
            $uri = substr($uri, 0, $position);
        }

        $routeInfo = $this->dispatcher->dispatch($httpMethod, rawurldecode($uri));

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                $this->container->get(Renderer::class)->render('error/404');
                return;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                header('Allow: ' . implode(', ', $routeInfo[1]));
                $this->container->get(Renderer::class)->render('error/405');
                return;

            case Dispatcher::FOUND:
                [$controllerClass, $method] = $routeInfo[1];
                $controller = $this->container->get($controllerClass);
                $controller->$method($routeInfo[2]);
                return;
        }
    }
}
