<?php

namespace App\Controllers;

use App\Models\WeatherData;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

class TwigController
{
    public function twig(): Environment
    {
        $twig = new FilesystemLoader("app/Views/");
        return new Environment($twig);

    }

}
