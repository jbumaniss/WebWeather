<?php


namespace App\Services;


use App\Models\WeatherDataCollection;
use App\Repositories\WeatherDataRepository;


class WeatherDataService
{
    private WeatherDataRepository $weatherDataRepository;

    public function __construct(WeatherDataRepository $weatherDataRepository)
    {
        $this->weatherDataRepository = $weatherDataRepository;
    }

    public function execute(): WeatherDataCollection
    {
        return $this->weatherDataRepository->requestWeatherData();
    }

}
