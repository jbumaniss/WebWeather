<?php

namespace App\Services;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigController
{
    public function twig(): Environment
    {
        $twig = new FilesystemLoader("app/Views/");
        return new Environment($twig);
    }

}
