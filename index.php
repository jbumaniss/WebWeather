<?php

use App\Services\ConfigService;
use App\Services\SessionService;
use App\Services\TwigController;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use App\Services\WeatherDataService;
use App\Repositories\WeatherApiDataRepository;
use GuzzleHttp\Client;

require_once 'vendor/autoload.php';

session_start();

$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', "App\Controllers\WeatherController@index");
    $r->addRoute('POST', '/search', "App\Controllers\WeatherController@search");
    $r->addRoute('GET', '/contacts', "App\Controllers\ContactController@contacts");
    $r->addRoute('GET', '/apiForecast', "App\Controllers\WeatherController@linkToApiWebsiteForecast");

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    SessionService::class => \DI\create(SessionService::class),
    ConfigService::class => \DI\create(ConfigService::class),
    Client::class => \DI\create(Client::class),
    WeatherApiDataRepository::class => \DI\autowire()
        ->constructor(\DI\get(SessionService::class), \DI\get(ConfigService::class), \DI\get(Client::class)),
    WeatherDataService::class => \DI\autowire()
        ->constructor(\DI\get(WeatherApiDataRepository::class)),
    App\Controllers\WeatherController::class => \DI\autowire()
        ->constructor(\DI\get(WeatherDataService::class), \DI\get(SessionService::class), \DI\get(ConfigService::class)),
]);
    $container = $containerBuilder->build();

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

        $controllerInstance = $container->get($controller);

        $view = $controllerInstance->$method();

        if ($view instanceof \App\TemplateView) {
            $twigConfig = new TwigController();
            $template = $twigConfig->twig()->load($view->getTemplatePath());
            echo $template->render($view->getData());
            break;
        }

}