<?php

declare(strict_types=1);

use App\Application;
use App\HttpApplication;
use DI\ContainerBuilder;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/View/helpers.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(
    dirname(__DIR__) . '/config/container.php'
);

$container = $builder->build();

if (PHP_SAPI === 'cli') {
    $container->get(Application::class)->run();
    return;
}

$container->get(HttpApplication::class)->run();
