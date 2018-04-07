<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Landlord extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user contacting the landlord.
     *
     * @array
     */
    protected $user;

    /**
     * The rental history.
     *
     * @array
     */
    protected $rental_history;

    /**
     * The message for the email.
     *
     * @string
     */
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $rental_history, $message)
    {
        $this->user = $user;
        $this->rental_history = $rental_history;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $history_user = $this->rental_history->user;
        $user_name = $history_user->first_name . ' ' . $history_user->last_name;
        $content = (object)[
            'landlord_first_name' => $this->rental_history->landlord_first_name,
            'user_name' => $user_name,
            'message' => $this->message
        ];

        return $this->view([ 'emails.contact-landlord', 'emails.plain.contact-landlord' ])
            ->with('user', $this->user)
            ->with('content', $content)
            ->subject('Previous tenant inquiry about ' . $user_name);
    }
}
