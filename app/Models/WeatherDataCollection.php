<?php

namespace App\Models;

use Carbon\CarbonImmutable;

class WeatherDataCollection
{
    private array $whetherArray = [];

    public function __construct(array $weatherData)
    {
        $carbon = CarbonImmutable::now();
        $yesterday12Hours = $carbon->subtract(12, 'hour')->isoFormat('HH');

        $totalWeatherDataHours = count($weatherData);

        $yesterday = (int)$yesterday12Hours;

        $today = $yesterday + 24;

        if ($today > $totalWeatherDataHours) {
            $today -= 1;
        }

        for ($i = $yesterday; $i <= $today; $i++) {
            $this->addWeatherData($weatherData[$i]);
        }
    }

    public function addWeatherData(WeatherData $whetherData): void
    {
        $this->whetherArray[] = $whetherData;
    }

    public function getWhetherData(): array
    {
        return $this->whetherArray;
    }
}
