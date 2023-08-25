<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class StockController extends Controller
{

    /**
     * GET ALL STOCKS
     */
    public function stocks( Request $request  ){
            $header = $request->header('Authorization');

            if( empty($header) || $header != config('stock.central_api_key') ){

                $message ="Header Authorization missing";
                return response()->json([ "status" =>false, "message" => $message ], 422);
            }else{

                $stocks = Stock::all();
               return response()->json([ "stocks" => $stocks ], 200 );
                
            }

        
    }



    /**
     * FILTER STOCKS BY TICKER
     */
    public function filter_stocks_by_ticker(Request $request, $key  ){

            $header = $request->header('Authorization');
            if( empty($header) || $header != config('stock.central_api_key') ){

                $message ="Header Authorization missing";
                return response()->json([ "status" =>false, "message" => $message ], 422);
            }
           
          if( !in_array( $key,  config('stock.stock_tickers') ) ){

                $message ="Ticker not found inthe list";
                return response()->json([ "status" =>false, "message" => $message ], 422);
          }else{

            $stocks = Stock::all()->where('ticker',$key);

            return response()->json([ "stocks" => $stocks ], 200 );

          }

           



    }


    
    /**
     * SORT STOCKS BY TICKER  [ ASC, DESC]
     */
    public function sort_stocks( Request $request, $key  ){
        $header = $request->header('Authorization');
        if( empty($header) || $header != config('stock.central_api_key') ){

            $message ="Header Authorization missing";
            return response()->json([ "status" =>false, "message" => $message ], 422);
        }


        if( !in_array( $key,  config('stock.sort') ) ){

            $key = 'Desc';

        }else{

            $stocks = Stock::orderBy('created_at',$key)->get();
            return response()->json([ "stocks" => $stocks ], 200 );

        }

    }



   


}
