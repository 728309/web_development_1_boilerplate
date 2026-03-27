<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\HomeController', 'home']);
    $r->addRoute('GET', '/hello/{name}', ['App\Controllers\HelloController', 'greet']);
    $r->addRoute('GET', '/mixes', ['App\Controllers\MixController', 'index']);
    $r->addRoute('GET', '/mixes/{slug}', ['App\Controllers\MixController', 'show']);
    $r->addRoute(['GET', 'POST'], '/login', ['App\Controllers\UserController', 'login']);
    $r->addRoute('GET', '/logout', ['App\Controllers\UserController', 'logout']);
    $r->addRoute(['GET', 'POST'], '/register', ['App\Controllers\UserController', 'register']);
    $r->addRoute(['GET', 'POST'], '/admin/create-mix', ['App\Controllers\MixController', 'create']);
    $r->addRoute('POST', '/mixes/{slug}/comments', ['App\Controllers\MixController', 'storeComment']);
    $r->addRoute('GET', '/api/mixes/{slug}/votes', ['App\Controllers\MixController', 'GetVotes']);
    $r->addRoute('POST', '/api/mixes/{slug}/votes', ['App\Controllers\MixController', 'StoreVote']);
    $r->addRoute('GET', '/submissions/submit', ['App\Controllers\SubmissionController', 'create']);
    $r->addRoute('POST', '/submissions', ['App\Controllers\SubmissionController', 'store']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        $title = 'Page not found';
        $message = 'The page you requested does not exist.';
        require __DIR__ . '/../src/Views/errors/page404.php';
        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        $title = 'Method not allowed';
        $message = 'This page does not accept that request method.';
        require __DIR__ . '/../src/Views/errors/page404.php';
        break;

    case Dispatcher::FOUND:
        [$controllerClass, $methodName] = $routeInfo[1];
        $vars = $routeInfo[2];

        $controller = new $controllerClass();
        $controller->$methodName($vars);
        break;
}
