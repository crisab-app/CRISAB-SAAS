<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeChurchMail extends Mailable
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
        return $this->subject('¡Bienvenido a administrarme.com! - Instrucciones de uso')
                    ->view('emails.welcome_church')
                    // Aquí le decimos que adjunte el PDF que estará en la carpeta public
                    ->attach(public_path('documentos/instrucciones.pdf')); 
    }
}