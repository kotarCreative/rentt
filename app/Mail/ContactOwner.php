<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactOwner extends Mailable
{
    use Queueable, SerializesModels;

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
     * @array
     */
    protected $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $owner, $content)
    {
        $this->user = $user;
        $this->owner = $owner;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view([ 'emails.contact-owner', 'emails.plain.contact-owner' ])
            ->with('user', $this->user)
            ->with('owner', $this->owner)
            ->with('content', $this->content)
            ->subject('Someone would like to view your property!');
    }
}
