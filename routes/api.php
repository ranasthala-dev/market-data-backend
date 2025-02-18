<?php

use App\Http\Controllers\MarketDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/get-market-data', MarketDataController::class, 'getMarketData');
Route::post('/feed-market-data', [MarketDataController::class, 'feedMarketData']);
Route::post('/bse-feed-market-data', [MarketDataController::class, 'feedBseMarketData']);
Route::post('/bse-feed-delivery-data', [MarketDataController::class, 'feedBseDelivery']);
Route::post('/feed-high-low-data', [MarketDataController::class, 'feedHighLow']);
Route::get('/get-market-data', [MarketDataController::class, 'getMarketData']);
Route::get('/get-stock-data', [MarketDataController::class, 'getDataset']);


