<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Account;
use Mail;

class SendMailFired
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
     * @param  \App\Events\SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $user = User::find($event->userId)->toArray();
        $data = ['user' => User::find($event->userId)];
        Mail::send('emails.mailEvent', $data, function($message) use ($user) {
        $message->to($user['email']);
        $message->subject('Credential Information');
        });
    }
}
