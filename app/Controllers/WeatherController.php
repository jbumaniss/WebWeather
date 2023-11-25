<?php

namespace App\Controllers;

use App\Services\ConfigService;
use App\Services\SessionService;
use App\Services\WeatherDataService;
use App\TemplateView;

class WeatherController
{
    private WeatherDataService $service;
    private SessionService $sessionService;
    private string $city;

    public function __construct(WeatherDataService $weatherDataService, SessionService $sessionService, ConfigService $configService)
    {
        $this->service = $weatherDataService;
        $this->sessionService = $sessionService;
        $this->city = $configService->get('DEFAULT_CITY');
    }

    public function index(): TemplateView
    {
        $cityNotFound = $this->sessionService->get('cityNotFound', false);

        return new TemplateView("index.view.html.twig", [
            'data' => $this->service->execute()->getWhetherData(),
            'search' => $this->getCity(),
            'cityNotFound' => $cityNotFound
        ]);
    }

    public function search()
    {
        $search = $_REQUEST['search'] ?? '';

        if (empty($search)) {
            header('Location: /');
            return;
        }

        $cleanFromNonAlpha = preg_replace("/[^A-Za-z0-9 ]/", '', $search);

        $this->setCity($cleanFromNonAlpha);

        header('Location: /');
    }

    public function getCity(): string
    {
        return $_SESSION['search'] ?? $this->city;
    }

    private function setCity(string $city): void
    {
        $this->city = !empty($city) ? $city : 'Riga';
        $_SESSION['search'] = $this->city;
    }

    public function linkToApiWebsiteForecast()
    {
        $encodedCity = urlencode($this->getCity());
        header('Location: https://www.weatherapi.com/weather/q/' . $encodedCity);
    }
}
