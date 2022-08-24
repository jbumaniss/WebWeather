<?php

namespace App\Controllers;

use App\Services\WeatherDataService;
use App\TemplateView;

class WeatherIndexController
{
    private WeatherDataService $service;
    private string $city;

    public function __construct(WeatherDataService $weatherDataService)
    {
        $this->service = $weatherDataService;
    }

    public function index(): TemplateView
    {
        return new TemplateView("index.view.html.twig", [
            'data' => $this->service->execute()->getWhetherData(),
            'search' => $_SESSION['search']
        ]);
    }

    public function contacts(): TemplateView
    {
        return new TemplateView("contacts.view.html.twig", ['data' => $this->service->execute()->getWhetherData()]);
    }

    public function search()
    {
        $cleanFromNonAlpha = preg_replace("/[^A-Za-z0-9 ]/", '', $_REQUEST['search']);

        if ($_SESSION['search']) {
            $this->city = $cleanFromNonAlpha;
        } else {
            $this->city = 'Riga';
        }


        $_SESSION['search'] = $this->getCity();
        header('Location: /');
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function linkToApiWebsiteForecast()
    {
        header('Location: https://www.weatherapi.com/weather/q/' . $_SESSION['search']);
    }
}
