<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailtrapExample extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
        public function build()
        {
//            app('view')->addNamespace('mails', resource_path('views') . '/mails');

            return $this->markdown('mails.exmpl')
                ->from('admin@website-health-checker.com', 'Mailtrap')
                ->subject('Mailtrap Confirmation')
                ->with([
                    'name' => 'New Mailtrap User',
                    'link' => 'https://mailtrap.io/inboxes'
                ]);
        }
}
