<?php

namespace App\Controllers;

use App\Services\WeatherDataService;
use App\TemplateView;

class WeatherIndexController
{
    private WeatherDataService $service;

    public function __construct(WeatherDataService $weatherDataService)
    {
        $this->service = $weatherDataService;
    }

    public function index(): TemplateView
    {
        return new TemplateView("index.view.html.twig", ['data' => $this->service->execute()->getWhetherData()]);
    }

    public function contacts(): TemplateView
    {
        return new TemplateView("contacts.view.html.twig", ['data' => $this->service->execute()->getWhetherData()]);
    }
}
