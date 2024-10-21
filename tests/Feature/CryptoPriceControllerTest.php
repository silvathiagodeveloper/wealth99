<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CryptoPriceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_latest_price()
    {
        $response = $this->get('/api/prices/latest?coin=bitcoin');
        $response->assertStatus(200)
                 ->assertJsonStructure(['coin', 'price']);
    }

    public function test_get_historical_price()
    {
        $dateTime = '2024-10-21%2012:00:00';
        $response = $this->get('/api/prices/historical?coin=bitcoin&datetime=' . $dateTime);
        $response->assertStatus(200)
                 ->assertJsonStructure(['coin', 'price', 'datetime']);
    }

    public function test_get_latest_price_invalid_coin()
    {
        $response = $this->get('/api/prices/latest?coin=invalidcoin');
        $response->assertStatus(422);
    }

    public function test_get_historical_price_invalid_coin()
    {
        $dateTime = '2023-10-01T12:00:00Z';
        $response = $this->get('/api/prices/historical?coin=invalidcoin&datetime=' . $dateTime);
        $response->assertStatus(422);
    }
}