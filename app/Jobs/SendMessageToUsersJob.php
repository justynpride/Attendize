<?php

namespace App\Jobs;

use App\Mail\SendMessageToUsersMail;
use App\Models\User;
use App\Models\Event;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Config;
use Mail;

class SendMessageToUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->message->recipients == 'all') {
            $recipients = $this->message->organiser->users;
        }

        $event = $this->message->event;

        foreach ($recipients as $user) {

            $mail = new SendMessageToUsersMail($this->message->subject, $this->message->message, $organiser, $user);
            Mail::to($user->email, $user->full_name)
                ->locale(Config::get('app.locale'))
                ->send($mail);
        }

        $this->message->is_sent = 1;
        $this->message->sent_at = Carbon::now();
        $this->message->save();
    }
}