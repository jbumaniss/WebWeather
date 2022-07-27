<?php


namespace App\Repositories;

use App\Models\WeatherData;
use App\Models\WeatherDataCollection;
use App\Services\DateTimeService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class WeatherApiDataRepository implements WeatherDataRepository
{

    public function requestWeatherData(): WeatherDataCollection
    {
        $urlOfHistory = $_ENV['BASE_URL'] . $_ENV['DESTINATION'];
        $response = [];

        $parametersOfHistory = [
            'key' => $_ENV['API_KEY'],
            "q" => $_ENV['CITY'],
            'dt' => DateTimeService::getYesterday(),
            'end_dt' => DateTimeService::getTimeNow(),
        ];

        $qsForHistory = http_build_query($parametersOfHistory);

        $requestUrlForHistory = "$urlOfHistory?$qsForHistory";

        $client = new Client();

        try {
            $response = $client->request('GET', $requestUrlForHistory);
        } catch (ClientException $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        } catch (GuzzleException $e) {
            echo $e;
        }
        $request = json_decode($response->getBody());


        $data = [];

        $hours = count($request->forecast->forecastday[1]->hour);

        foreach ($request->forecast->forecastday[0]->hour as $hourResponse) {
            $data[] = new WeatherData(
                (string)$hourResponse->time,
                (string)$hourResponse->temp_c,
                (string)$hourResponse->humidity,
                (string)substr($hourResponse->condition->icon, 2),
                (string)$hourResponse->cloud,
                (string)$hourResponse->wind_kph
            );
        }

        for ($i = 0; $i < $hours; $i++) {
            $data[] = new WeatherData(
                (string)$request->forecast->forecastday[1]->hour[$i]->time,
                (string)$request->forecast->forecastday[1]->hour[$i]->temp_c,
                (string)$request->forecast->forecastday[1]->hour[$i]->humidity,
                (string)substr($request->forecast->forecastday[1]->hour[$i]->condition->icon, 2),
                (string)$request->forecast->forecastday[1]->hour[$i]->cloud,
                (string)$request->forecast->forecastday[1]->hour[$i]->wind_kph
            );
        }
        return new WeatherDataCollection($data);
    }
}
