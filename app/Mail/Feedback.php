<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The person sending feedback.
     *
     * @string
     */
    protected $name;

    /**
     * The type of issue being reported.
     *
     * @string
     */
    protected $issue;

    /**
     * If the person wishes to be responded to.
     *
     * @string
     */
    protected $respond;

    /**
     * Content for the email.
     *
     * @string
     */
    protected $content;

    /**
     * The persons email if they want a response.
     *
     * @string
     */
    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $issue, $respond, $content, $email = '')
    {
        $this->name = $name;
        $this->issue = $issue;
        $this->respond = $respond;
        $this->content = $content;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = (object) [
            'first_name' => 'Mike or Dave'
        ];

        $content = (object) [
            'name' => $this->name,
            'email' => $this->email,
            'issue' => $this->issue,
            'respond' => $this->respond,
            'message' => $this->content
        ];

        return $this->view([ 'emails.feedback', 'emails.plain.feedback' ])
            ->with('user', $user)
            ->with('content', $content)
            ->subject('Feedback from Rentt.io');
    }
}
