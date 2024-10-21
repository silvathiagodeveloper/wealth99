<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoPriceRequest;
use App\Http\Requests\HistoricalPriceRequest;
use App\Services\CoinGeckoService;
use App\Models\CryptoPrice;

class CryptoPriceController extends Controller
{
    private $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }

    public function getLatestPrice(CryptoPriceRequest $request)
    {
        $coin = $request->query('coin');
        $cachedPrice = CryptoPrice::where('coin', $coin)
            ->where('recorded_at', '>=', now()->subMinutes(5))
            ->latest('recorded_at')
            ->first();

        if ($cachedPrice) {
            return response()->json([
                'coin' => $coin,
                'price' => $cachedPrice->price
            ]);
        }

        $data = $this->coinGeckoService->getCurrentPrice($coin);
        $price = $data[$coin]['usd'] ?? null;
        if(!empty($data)){
            CryptoPrice::create([
                'coin' => $coin,
                'price' => $price,
                'recorded_at' => now(),
            ]);
        }

        return response()->json(['coin' => $coin, 'price' => $price]);
    }

    public function getHistoricalPrice(HistoricalPriceRequest $request)
    {
        $coin = $request->query('coin');
        $datetime = $request->query('datetime');
        $date = \Carbon\Carbon::parse($datetime);
    
        $historicalPrice = CryptoPrice::where('coin', $coin)
            ->whereDate('recorded_at', $date)
            ->first();
    
        if ($historicalPrice) {
            return response()->json([
                'coin' => $coin,
                'price' => $historicalPrice->price,
                'datetime' => $historicalPrice->recorded_at
            ]);
        }
    
        $data = $this->coinGeckoService->fetchHistoricalPrice($coin, $date);
        $price = $data['market_data']['current_price']['usd'] ?? null;
    
        if ($price !== null) {
            CryptoPrice::create([
                'coin' => $coin,
                'price' => $price,
                'recorded_at' => $date,
            ]);
        }
    
        return response()->json([
            'coin' => $coin,
            'price' => $price,
            'datetime' => $datetime
        ]);
    }
}