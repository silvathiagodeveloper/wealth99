<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CryptoPriceControllerTest extends TestCase
{
    use RefreshDatabase; // Se você usar o banco de dados, isso garante que os testes sejam realizados em um banco limpo.

    public function test_get_latest_price()
    {
        // Testa se o endpoint para obter o preço mais recente retorna uma resposta bem-sucedida
        $response = $this->get('/api/prices/latest?coin=bitcoin'); // Usar 'bitcoin' como exemplo
        $response->assertStatus(200)
                 ->assertJsonStructure(['coin', 'price']);
    }

    public function test_get_historical_price()
    {
        // Testa se o endpoint para obter o preço histórico retorna uma resposta bem-sucedida
        $dateTime = '2023-10-01T12:00:00Z'; // Data e hora no formato UTC
        $response = $this->get('/api/prices/historical?coin=bitcoin&datetime=' . $dateTime);
        $response->assertStatus(200)
                 ->assertJsonStructure(['coin', 'price', 'datetime']);
    }

    public function test_get_latest_price_invalid_coin()
    {
        // Testa se o endpoint retorna um erro para uma criptomoeda inválida
        $response = $this->get('/api/prices/latest?coin=invalidcoin');
        $response->assertStatus(404); // Você pode ajustar este status conforme o comportamento da sua API
    }

    public function test_get_historical_price_invalid_coin()
    {
        // Testa se o endpoint retorna um erro para uma criptomoeda inválida
        $dateTime = '2023-10-01T12:00:00Z'; // Data e hora no formato UTC
        $response = $this->get('/api/prices/historical?coin=invalidcoin&datetime=' . $dateTime);
        $response->assertStatus(404); // Você pode ajustar este status conforme o comportamento da sua API
    }
}