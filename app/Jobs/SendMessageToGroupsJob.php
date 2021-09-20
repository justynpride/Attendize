<?php

namespace App\Jobs;

use App\Mail\SendMessageToGroupsMail;
use App\Models\Group;
use App\Models\Organiser;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Config;
use Mail;

class SendMessageToGroupsJob implements ShouldQueue
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
            $recipients = $this->message->organiser->groups;
        } else {
            $recipients = Group::where('ticket_id', '=', $this->message->recipients)->where('account_id', '=', $this->message->account_id)->get();
        }

        $organiser = $this->message->organiser;

        foreach ($recipients as $group) {

            $mail = new SendMessageToAttendeesMail($this->message->subject, $this->message->message, $organiser, $group);
            Mail::to($group->email, $group->name)
                ->locale(Config::get('app.locale'))
                ->send($mail);
        }

        $this->message->is_sent = 1;
        $this->message->sent_at = Carbon::now();
        $this->message->save();
    }
}