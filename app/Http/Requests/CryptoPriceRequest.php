<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CryptoPriceRequest extends FormRequest
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

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coin' => 'required|string|in:' . implode(',', array_column($this->validCoins, 'id'))
        ];
    }

    public function messages()
    {
        return [
            'coin.in' => 'The :attribute field must be one of the following values: ' . implode(', ', array_column($this->validCoins, 'id')),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}