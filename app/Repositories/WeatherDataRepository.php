<?php

namespace App\Repositories;


use App\Models\WeatherDataCollection;

interface WeatherDataRepository
{
    public function requestWeatherData(): WeatherDataCollection;
}
