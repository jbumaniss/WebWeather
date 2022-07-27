<?php


namespace App\Controllers;

use App\Models\WeatherData;
use DateTime;

class WeatherDataController
{
    public function data(): array
    {
        $data = [];

        $request = (new GuzzleController())->request();

        $hours = count($request->forecast->forecastday[1]->hour);

        foreach ($request->forecast->forecastday[0]->hour as $hourResponse) {
            $data[] = new WeatherData(
                $hourResponse->time,
                $hourResponse->temp_c,
                $hourResponse->humidity,
                substr($hourResponse->condition->icon, 2)
            );
        }

        for ($i = 0; $i < $hours - 3; $i++) {
            $data[] = new WeatherData(
                $request->forecast->forecastday[1]->hour[$i]->time,
                $request->forecast->forecastday[1]->hour[$i]->temp_c,
                $request->forecast->forecastday[1]->hour[$i]->humidity,
                substr($request->forecast->forecastday[1]->hour[$i]->condition->icon, 2)
            );
        }

        $twelveHourData = [];
        $currentHour = date('H');
        $date = new DateTime();
        $date->modify("-12 hour");
        $lastTwelveHours = $date->format("H");
        $date->modify("+24 hour");


        $nextTwelveHours = $date->format("H");
        if (($nextTwelveHours * 2) < ($currentHour * 2)){
            $nextTwelveHours = "47";
        }
        for ($i = $lastTwelveHours -1; $i <= 47; $i++) {
            $twelveHourData[] = $data[$i];
        }
        return $twelveHourData;
    }
}