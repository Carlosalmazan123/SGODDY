<?php

use DragonCode\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class CitaPendienteNotification extends Notification implements ShouldQueue

{
     use Queueable;

    protected $citasCount;

    public function __construct($citasCount)
    {
        $this->citasCount = $citasCount;
    }

    public function via($notifiable)
    {
        // Notificación en tiempo real (broadcast) + base de datos
        return ['broadcast', 'database'];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Recordatorio de Citas',
            'body'  => "Hoy tienes {$this->citasCount} citas pendientes.",
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Recordatorio de Citas',
            'body'  => "Hoy tienes {$this->citasCount} citas pendientes.",
        ];
    }
}
