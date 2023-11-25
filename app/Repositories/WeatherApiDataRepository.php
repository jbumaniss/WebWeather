<?php


namespace App\Repositories;

use App\Models\WeatherData;
use App\Models\WeatherDataCollection;
use Carbon\CarbonImmutable;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use App\Services\SessionService;
use App\Services\ConfigService;

class WeatherApiDataRepository implements WeatherDataRepository
{
    private SessionService $sessionService;
    private ConfigService $configService;
    private Client $httpClient;

    public function __construct(SessionService $sessionService, ConfigService $configService, Client $httpClient)
    {
        $this->sessionService = $sessionService;
        $this->configService = $configService;
        $this->httpClient = $httpClient;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function requestWeatherData(): WeatherDataCollection
    {
        $urlOfHistory = $this->configService->get('BASE_URL') . $this->configService->get('DESTINATION');
        $city = $this->sessionService->get('search', $this->configService->get('DEFAULT_CITY'));
        $carbon = CarbonImmutable::now();

        $parametersOfHistory = [
            'key' => $this->configService->get('API_KEY'),
            "q" => $city,
            'dt' => $carbon->subHours(12)->isoFormat('Y-MMM-D'),
            'end_dt' => $carbon->addHours(12)->isoFormat('Y-MMM-D'),
        ];

        $requestUrlForHistory = "$urlOfHistory?" . http_build_query($parametersOfHistory);

        try {
            $this->sessionService->set('cityNotFound', false);
            $response = $this->httpClient->request('GET', $requestUrlForHistory);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 400) {
                $this->sessionService->set('cityNotFound', true);
                return new WeatherDataCollection([]);
            }

            throw new Exception("Error fetching weather data: " . $e->getMessage());
        }

        $request = json_decode($response->getBody());
        $data = $this->parseWeatherData($request);

        return new WeatherDataCollection($data);
    }

    private function parseWeatherData($request): array
    {
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

        return $data;
    }
}
