<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class AnalyticsHelper
{
    public static function sendGa4Event($clientId, $eventName, $parameters = []): bool
    {
        $measurementId = 'G-0XLX9M5RC6';
        $apiSecret = env('GA4_SECRET', '');
        $client = new Client();

        try {
            $response = $client->post('https://www.google-analytics.com/mp/collect', [
                'query' => [
                    'measurement_id' => $measurementId,
                    'api_secret' => $apiSecret,
                ],
                'json' => [
                    'client_id' => $clientId,
                    'events' => [
                        [
                            'name' => $eventName,
                            'params' => $parameters,
                        ],
                    ],
                ],
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }
}
