<?php

namespace App\Jobs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\Reference;

class SendReferenceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user contacting the landlord.
     *
     * @array
     */
    protected $user;

    /**
     * The reference.
     *
     * @string
     */
    protected $reference;

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
    public function __construct($user, $reference, $message)
    {
        $this->user = $user;
        $this->reference = $reference;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Reference($this->user, $this->reference, $this->message);

        Mail::to($this->reference->email)->send($email);
    }
}
