<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailSend;
use App\Models\User;
use App\Models\Stock;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/store', [ \App\Http\Controllers\StockController::class, 'store' ]);

//TEST SEND EMAIL
Route::get('/testroute', function () {

    $data  = DB::select("SELECT
    p_today.`ticker`,
    p_today.`market`,
    p_today.`created_at`,
    p_yest.current_price AS `open`,
    p_today.current_price AS `close`,
    ((p_today.current_price - p_yest.current_price)/p_yest.current_price) AS `change`
 FROM
    stocks p_today
    INNER JOIN stocks p_yest ON
        p_today.ticker = p_yest.ticker
        AND DATE(p_today.`created_at`) = DATE(p_yest.`created_at`) + INTERVAL 1 DAY
 
        AND p_yest.current_price > 0
 WHERE p_today.current_price > 0
     AND DATE(p_today.`created_at`) = CURRENT_DATE
 ORDER BY `change` DESC");


    
    $emails = User::pluck('email')->toArray();
    
    Mail::to($emails)->send( new EmailSend( $data ) );

});