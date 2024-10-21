<?php

namespace App\Services;

use GuzzleHttp\Client;

class CoinGeckoService
{
    private $client;
    private $apiUrl = 'https://api.coingecko.com/api/v3/';

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getCurrentPrice($coin)
    {
        $response = $this->client->get($this->apiUrl . 'simple/price', [
            'query' => [
                'ids' => $coin,
                'vs_currencies' => 'usd',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function fetchHistoricalPrice($coin, $date)
    {
        $response = $this->client->get($this->apiUrl . 'coins/' . $coin . '/history', [
            'query' => [
                'date' => $date->format('d-m-Y'),
                'localization' => 'false',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}