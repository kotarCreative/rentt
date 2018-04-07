<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Reference extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user contacting the reference.
     *
     * @array
     */
    protected $user;

    /**
     * The reference.
     *
     * @array
     */
    protected $reference;

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
    public function __construct($user, $reference, $message)
    {
        $this->user = $user;
        $this->reference = $reference;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ref_user = $this->reference->user;
        $user_name = $ref_user->first_name . ' ' . $ref_user->last_name;

        $content = (object)[
            'reference_first_name'  => $this->reference->first_name,
            'user_name'             => $user_name,
            'message'               => $this->message

        ];

        return $this->view([ 'emails.contact-reference', 'emails.plain.contact-reference' ])
            ->with('user', $this->user)
            ->with('content', $content)
            ->subject('I would like to know more about ' . $user_name);
    }
}
