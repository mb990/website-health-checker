<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $projectInvitationData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectInvitationData)
    {
        $this->projectInvitationData = $projectInvitationData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->projectInvitationData['senderEmail'], $this->projectInvitationData['senderName'])
            ->subject('Project invite')
            ->to($this->projectInvitationData['recipientEmail'], $this->projectInvitationData['recipientName'])
//            ->markdown('notifications:email')
//            ->markdown($this->data['senderName'] . ' invited you to join project ' . $this->data['project'])
            ->view('emails.project-invite');
    }
}
