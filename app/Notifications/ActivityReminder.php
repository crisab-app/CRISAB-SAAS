<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityReminder extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;
    public $icon;

    // Recibimos los datos del aviso cuando lo creamos
    public function __construct($title, $message, $url = '#', $icon = '📅')
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->icon = $icon;
    }

    // Le decimos a Laravel que por ahora SOLO lo guarde en la Base de Datos (Campanita)
    // (En el futuro, aquí agregaremos 'onesignal' para las Push)
    public function via($notifiable)
    {
        return ['database'];
    }

    // Le damos formato a los datos que se guardarán en la tabla
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'icon' => $this->icon,
        ];
    }
}