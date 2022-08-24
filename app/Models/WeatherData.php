<?php


namespace App\Models;

class WeatherData
{
    private string $date;
    private float $temperature;
    private float $humidity;
    private string $icon;
    private float $cloud;
    private float $windKph;

    public function __construct(
        string $date,
        float $temperature,
        float $humidity,
        string $icon,
        float $cloud,
        float $windKph
    ) {
        $this->date = $date;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->icon = $icon;
        $this->cloud = $cloud;
        $this->windKph = $windKph;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTemperature(): float
    {
        return $this->temperature;
    }

    public function getHumidity(): float
    {
        return $this->humidity;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }


    public function getCloud(): float
    {
        return $this->cloud;
    }


    public function getWindKph(): float
    {
        return $this->windKph;
    }

    public function isCurrentHour(): bool
    {
        return date('d H', strtotime($this->date)) == date("d H");
    }

}