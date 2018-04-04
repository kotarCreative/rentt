<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferenceApproval extends Mailable
{
    use Queueable, SerializesModels;

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
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $reference)
    {
        $this->user = $user;
        $this->reference = $reference;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view([ 'emails.reference', 'emails.plain.reference' ])->with('user', $this->user)->with('reference', $this->reference)
                ->subject($this->user->first_name . ' has requested to use you as a reference.');
    }
}
