<?php


namespace App\Services;


use App\Models\WeatherDataCollection;
use App\Repositories\WeatherDataRepository;


class WeatherDataService
{
    private WeatherDataRepository $articleRepository;

    public function __construct(WeatherDataRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(): WeatherDataCollection
    {
        return $this->articleRepository->requestWeatherData();
    }

}
