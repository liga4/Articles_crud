<?php
declare(strict_types=1);
use App\Controllers\ArticleController;
use App\RedirectResponse;
use App\ViewResponse;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';

$loader = new FilesystemLoader('../views');

$twig = new Environment($loader);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/', [ArticleController::class, 'index']);
    $router->addRoute('GET', '/articles', [ArticleController::class, 'index']);
    $router->addRoute('GET', '/articles/create', [ArticleController::class, 'create']);
    $router->addRoute('POST', '/articles', [ArticleController::class, 'store']);
    $router->addRoute('GET', '/articles/{id:\d+}', [ArticleController::class, 'show']);
    $router->addRoute('GET', '/articles/{id:\d+}/edit', [ArticleController::class, 'edit']);
    $router->addRoute('POST', '/articles/{id:\d+}', [ArticleController::class, 'update']);
    $router->addRoute('POST', '/articles/{id:\d+}/delete', [ArticleController::class, 'delete']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uri = rawurldecode($uri);
$container = require_once __DIR__ . '/../app/config.php';
$articleRepository = $container->get('ArticleRepository');


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = (new $controller)->{$method}(...array_values($vars));
        switch (true)
        {
            case $response instanceof ViewResponse:
                echo $twig->render($response->getViewName() . '.twig', $response->getData());
                break;
            case $response instanceof RedirectResponse:
                header('Location: ' . $response->getLocation());
                break;
            default:
                break;
        }
        break;
}


