<?php

namespace App\Models;

use App\Services\DateTimeService;

class WeatherDataCollection
{
    private array $whetherArray = [];

    public function __construct(array $weatherData)
    {
        $time= new DateTimeService();
        $yesterdayHours = $time->getSub12Hours();

        $yesterday = count($weatherData) / 2 + (int)$yesterdayHours;
        $today = $yesterday + 24;
        $totalWeatherDataHours = count($weatherData);

        if ($today > $totalWeatherDataHours) {
            $today = $totalWeatherDataHours -1;
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
