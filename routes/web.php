<?php

use App\Http\Controllers\MarketDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-market-data', [MarketDataController::class, 'getMarketData'])->name('market-data');
Route::get('/get-stock-data', [MarketDataController::class, 'getDataset'])->name('stock-data');











