<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Organiser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageToUsersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $event;
    public $attendee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, Organiser $organiser, User $user)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->event = $organiser;
        $this->attendee = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->from(config('attendize.outgoing_email_noreply'), $this->organiser->name)
                    ->replyTo($this->organiser->email, $this->organiser->name)
                    ->view('Emails.MessageToUsers');
    }
}