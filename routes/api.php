<?php

use App\Http\Controllers\CryptoPriceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/prices/latest', [CryptoPriceController::class, 'getLatestPrice']);
Route::get('/prices/historical', [CryptoPriceController::class, 'getHistoricalPrice']);