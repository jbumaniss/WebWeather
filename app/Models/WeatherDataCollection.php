<?php

namespace App\Models;

use Carbon\CarbonImmutable;

class WeatherDataCollection
{
    private array $whetherArray = [];

    public function __construct(array $weatherData)
    {
        $twelveHoursAgo = CarbonImmutable::now()->subHours(12);

        foreach ($weatherData as $data) {
            $dataTime = CarbonImmutable::createFromFormat('Y-m-d H:i', $data->getDate());
            if ($dataTime >= $twelveHoursAgo) {
                $this->addWeatherData($data);
            }
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
