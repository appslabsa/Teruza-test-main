<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

Route::get('/', [SiteController::class, 'viewHome']);

use App\Http\Controllers\CurrencyController;

Route::get('/api/forex-rates', [CurrencyController::class, 'getRates']);
Route::post('/api/convert', [CurrencyController::class, 'convert']);
