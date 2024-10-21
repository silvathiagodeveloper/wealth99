<?php

namespace App\Http\Controllers;

use App\Services\CoinGeckoService;
use App\Models\CryptoPrice;
use Illuminate\Http\Request;

class CryptoPriceController extends Controller
{
    private $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }

    public function getLatestPrice(Request $request)
    {
        $coin = $request->query('coin');
        $data = $this->coinGeckoService->getCurrentPrice($coin);
        print_r($data);
        $price = $data[$coin]['usd'] ?? null;

        // Store price in the database
        CryptoPrice::create([
            'coin' => $coin,
            'price' => $price,
            'recorded_at' => now(),
        ]);

        return response()->json(['coin' => $coin, 'price' => $price]);
    }

    public function getHistoricalPrice(Request $request)
    {
        $coin = $request->query('coin');
        $datetime = $request->query('datetime');
        $date = \Carbon\Carbon::parse($datetime);

        $data = $this->coinGeckoService->fetchHistoricalPrice($coin, $date);
        $price = $data['market_data']['current_price']['usd'] ?? null;

        return response()->json(['coin' => $coin, 'price' => $price, 'datetime' => $datetime]);
    }
}