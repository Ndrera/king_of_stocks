<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Mail\EmailSend;
use Illuminate\Support\Facades\Mail;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'email:send';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily emails to users containing stock data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = User::pluck('email')->toArray();

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




        foreach( $emails as $email ){
            Mail::to($email)->send( new EmailSend( $data ) );
        }


    }

    




}
