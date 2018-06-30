<?php

namespace App\Jobs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\RentalHistoryApproval;

class SendRentalHistoryApprovalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user requesting the reference.
     *
     * @array
     */
    protected $user;

    /**
     * The rental history information.
     *
     * @array
     */
    protected $rental_history;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $rental_history)
    {
        $this->queue = 'emails';

        $this->user = $user;
        $this->rental_history = $rental_history;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new RentalHistoryApproval($this->user, $this->rental_history);

        Mail::to($this->rental_history->landlord_email)->send($email);
    }
}
