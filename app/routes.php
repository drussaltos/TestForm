<?php


use Aura\SqlQuery\QueryFactory;
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use League\Plates\Engine;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    Engine::class => function(){
        return new Engine('../app/Views');
    },

    Swift_Mailer::class => function() {
        $transport = (new Swift_SmtpTransport(
            config('mail.smtp'),
            config('mail.port'),
            config('mail.encryption')
        ))
            ->setUsername(config('mail.email'))
            ->setPassword(config('mail.password'));
        return new Swift_Mailer($transport);
    },

    PDO::class => function(){
        $driver = config('database.driver');
        $host = config('database.host');
        $database_name = config('database.database_name');
        $username = config('database.username');
        $password = config('database.password');

        return new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
    },

    QueryFactory::class  =>  function() {
        return new QueryFactory('mysql');
    }
]);

session_start();
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
$r->addRoute('GET', '/', ["App\controllers\Controller", "index"]);
$r->addRoute('POST', '/', ["App\controllers\AjaxController", "index"]);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ...
        dd("404 Not Found");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ...
        dd("405 Method Not Allowed");
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($handler, $vars);
        // ... call $handler with $vars
        break;
}