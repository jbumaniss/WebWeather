<?php

namespace App\Controllers;

use App\TemplateView;

class WeatherIndexController
{
    public function index(): TemplateView
    {
        return new TemplateView("index.view.html.twig", ['data' => (new WeatherDataController())->data()]);
    }

    public function contacts(): TemplateView
    {
        return new TemplateView("contacts.view.html.twig", ['data' => (new WeatherDataController())->data()]);
    }
}
