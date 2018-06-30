<?php

namespace App\Jobs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\Feedback;

class SendFeedbackEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $issue, $respond, $content, $email = '')
    {
        $this->queue = 'emails';

        $this->name = $name;
        $this->issue = $issue;
        $this->respond = $respond;
        $this->content = $content;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Feedback($this->name, $this->issue, $this->respond, $this->content, $this->email);

        Mail::to(env('ADMIN_EMAIL', ''))->send($email);
    }
}
