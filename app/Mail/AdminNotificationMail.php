<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $churchName;

    public function __construct($user, $churchName)
    {
        $this->user = $user;
        $this->churchName = $churchName;
    }

    public function build()
    {
        return $this->subject('🔔 Nueva Iglesia Registrada: ' . $this->churchName)
                    ->view('emails.admin_notification');
    }
}