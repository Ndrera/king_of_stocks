<?php

use Illuminate\Http\Request;
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


Route::get('/v4/quote', [ \App\Http\Controllers\StockController::class, 'stocks' ]);

Route::get('v4/quote/ticker/{key}', [ \App\Http\Controllers\StockController::class, 'filter_stocks_by_ticker' ]);

Route::get('v4/quote/sort/{key}', [ \App\Http\Controllers\StockController::class, 'sort_stocks' ]);

