<?php

namespace App\Jobs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\Landlord;

class SendLandlordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user contacting the landlord.
     *
     * @array
     */
    protected $user;

    /**
     * The rental history.
     *
     * @string
     */
    protected $rental_history;

    /**
     * The message for the email.
     *
     * @string
     */
    protected $message;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $rental_history, $message)
    {
        $this->queue = 'emails';

        $this->user = $user;
        $this->rental_history = $rental_history;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Landlord($this->user, $this->rental_history, $this->message);

        Mail::to($this->rental_history->landlord_email)->send($email);
    }
}
