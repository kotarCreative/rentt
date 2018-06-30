<?php

namespace App\Jobs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ReferenceApproval;

class SendReferenceApprovalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user requesting the reference.
     *
     * @array
     */
    protected $user;

    /**
     * The person being referenced.
     *
     * @array
     */
    protected $reference;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $reference)
    {
        $this->queue = 'emails';

        $this->user = $user;
        $this->reference = $reference;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new ReferenceApproval($this->user, $this->reference);

        Mail::to($this->reference->email)->send($email);
    }
}
