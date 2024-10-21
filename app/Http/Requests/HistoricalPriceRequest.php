<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricalPriceRequest extends FormRequest
{
    private $validCoins = [
        ["symbol" => "BTC", "id" => "bitcoin"],
        ["symbol" => "ETH", "id" => "ethereum"],
        ["symbol" => "ADA", "id" => "cardano"],
        ["symbol" => "DOT", "id" => "polkadot"],
        ["symbol" => "USDT", "id" => "tether"],
        ["symbol" => "LTC", "id" => "litecoin"],
        ["symbol" => "BNB", "id" => "binancecoin"],
        ["symbol" => "XRP", "id" => "ripple"],
        ["symbol" => "SOL", "id" => "solana"],
        ["symbol" => "MATIC", "id" => "polygon"],
        ["symbol" => "UNI", "id" => "uniswap"],
        ["symbol" => "LINK", "id" => "chainlink"],
        ["symbol" => "EOS", "id" => "eos"],
        ["symbol" => "AVAX", "id" => "avalanche-2"],
        ["symbol" => "USDC", "id" => "usd-coin"],
        ["symbol" => "XLM", "id" => "stellar"],
        ["symbol" => "MKR", "id" => "maker"],
        ["symbol" => "BAT", "id" => "basic-attention-token"],
        ["symbol" => "SAND", "id" => "the-sandbox"],
        ["symbol" => "BCH", "id" => "bitcoin-cash"],
        ["symbol" => "LUNC", "id" => "terra-luna"],
        ["symbol" => "DACXI", "id" => "dacxi"]
    ];

    public function rules()
    {
        $validCoinIds = array_column($this->validCoins, 'id');

        return [
            'coin' => 'required|in:' . implode(',', $validCoinIds),
            'datetime' => 'required|date_format:Y-m-d H:i:s'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'coin.required' => 'The :attribute field is required.',
            'coin.in' => 'The :attribute field must be one of the following values: ' . implode(', ', array_column($this->validCoins, 'id')),
            'datetime.required' => 'The :attribute field is required.',
            'datetime.date_format' => 'The :attribute field must be in the format Y-m-d H:i:s.'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}