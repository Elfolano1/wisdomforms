<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewUserMail;

class SendNewUserNotification
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
     * @param  \App\Events\NewUserEvent  $event
     * @return void
     */
    public function handle(NewUserEvent $event)
    {
        //
        
        ($event->user);
        $user=$event->user;
        User::create([
            'name' => $user['CandidateFirstName'],
            'email' => $user['CandidateEmail'],
            'password' => Hash::make('password'),
        ]);
        // $mailData=['user'=>$user['CandidateEmail'],'password'=>'password'];

        // Mail::to($user['CandidateEmail'])->send(new SendNewUserMail($mailData));
 
    }
}
