<?php


namespace App\Models;

use App\Controllers\GuzzleController;

class WeatherData
{
    private string $date;
    private float $temperature;
    private float $humidity;
    private string $icon;

    public function __construct(string $date, float $temperature, float $humidity, string $icon)
    {
        $this->date = $date;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->icon = $icon;
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

    public function isCurrentHour(): bool
    {
        return date('d H', strtotime($this->date)) == date("d H");
    }

}