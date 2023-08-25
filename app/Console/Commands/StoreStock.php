<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class StoreStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:store';   

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an api call and store the response data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return $this->store();

    }


    /**
     * MAKE AN API CALL 
     */
    public function make_api_call( $ticker ){
        $response = Http::get("https://financialmodelingprep.com/api/v3/quote-short/{$ticker}", [
            "apikey" => config('stock.api_key')
        ]);

        return json_decode( $response->body() );

    }

    /**
     * STORE THE API RESPONSE DATA 
     */
    public function store(){

        $stock_tickers = config('stock.stock_tickers');

        foreach( $stock_tickers  as $ticker){  

            $stocks = $this->make_api_call( $ticker );

            $stock = new Stock();

            $stock->ticker        = $stocks[0]->symbol;
            $stock->market        = config('stock.market');
            $stock->current_price = $stocks[0]->price;
            $stock->created_at    = Carbon::now();

            $stock->save();

        }

        return "Stock data fetched from external API and saved into the database";


    }



}
