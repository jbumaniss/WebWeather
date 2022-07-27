<?php

use App\Services\TwigController;
use App\TemplateView;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use App\Services\WeatherDataService;
use App\Repositories\WeatherApiDataRepository;

require_once 'vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', "App\Controllers\WeatherIndexController@index");
    $r->addRoute('GET', '/contacts', "App\Controllers\WeatherIndexController@contacts");
});


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 Not Found";

        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405 Method Not Allowed";

        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = explode("@", $handler);

        $twigConfig = new TwigController();

        /** @var TemplateView $view */
        $container = new Container();

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions([
            'WeatherDataService' => new WeatherDataService(
                new WeatherApiDataRepository()
            )
        ]);
        $container = $containerBuilder->build();

        $service = $container->get("WeatherDataService");

        $view = (new $controller($service))->$method();

        $template = $twigConfig->twig()->load($view->getTemplatePath());
        echo $template->render($view->getData());
        break;
}