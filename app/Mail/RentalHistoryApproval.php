<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RentalHistoryApproval extends Mailable
{
    use Queueable, SerializesModels;

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
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $rental_history)
    {
        $this->user = $user;
        $this->rental_history = $rental_history;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view([ 'emails.rental_history', 'emails.plain.rental_history' ])->with('user', $this->user)->with('rental_history', $this->rental_history)
                    ->subject($this->user->first_name . ' has requested to use you in their rental history.');
    }
}
