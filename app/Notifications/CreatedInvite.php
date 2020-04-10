<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreatedInvite extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($projectInvitationData)
    {
        $this->data = $projectInvitationData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject('Project invite')
            ->greeting('Hello!')
            ->line($this->data['senderName'] . ' invited you to join his project ' . $this->data['projectName'])
            ->action('See invitation', url('http://website-health-checker.test/invitation/' . $this->data['projectSlug'] . '/' . $this->data['recipientSlug'] . '/' . $this->data['token']))
            ->line('Thank you for using our application!')
            ->from($this->data['senderEmail'], $this->data['senderName']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
