<?php

namespace App\Controllers;

use App\Services\ConfigService;
use App\Services\SessionService;
use App\Services\WeatherDataService;
use App\TemplateView;

class ContactController
{
    public function contacts(): TemplateView
    {
        return new TemplateView("contacts.view.html.twig", []);
    }
}
