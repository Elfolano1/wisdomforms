<?php

namespace App\Listeners;

use App\Events\VerificationCodeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Models\VerificationCode;

class SendVerificationCodeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\VerificationCodeEvent  $event
     * @return void
     */
    public function handle(VerificationCodeEvent $event)
    {
        //
        $code = 'WF-'.rand(1231,7879);
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }  
        VerificationCode::create(
            ['table' => "interview_forms",
            'code'=>$code
            ]
        );
        $mailData=['code'=>$code];
        Mail::to('i.tchadjobo@wequipu.com')->send(new SendMail($mailData));

    }
}
