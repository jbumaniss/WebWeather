<?php


namespace App\Controllers;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleController
{

    public function request(): object
    {
        $date = new DateTime();
        $currentDate = date('Y-m-d');
        $date->modify("-1 day");
        $previousDate = $date;

        $urlOfHistory = 'https://api.weatherapi.com/v1/history.json';
        $apiKey = '642b2f3fb2154debbae85359222107';
        $response = [];

        $parametersOfHistory = [
            'key' => $apiKey,
            "q" => "Riga",
            'dt' => $previousDate->format("Y-m-d"),
            'end_dt' => $currentDate,
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
        return json_decode($response->getBody());
    }

}