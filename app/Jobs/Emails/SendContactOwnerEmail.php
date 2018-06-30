<?php

namespace App\Jobs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ContactOwner;

class SendContactOwnerEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user contacting the owner of a listing.
     *
     * @array
     */
    protected $user;

    /**
     * The owner of the listing.
     *
     * @array
     */
    protected $owner;

    /**
     * Content for the email.
     *
     * @string
     */
    protected $content;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $owner, $content)
    {
        $this->user = $user;
        $this->owner = $owner;
        $this->content = (object)$content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new ContactOwner($this->user, $this->owner, $this->content);

        Mail::to($this->owner->email)->send($email);
    }
}
