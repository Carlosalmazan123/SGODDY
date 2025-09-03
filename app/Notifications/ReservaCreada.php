<?php

namespace App\Notifications;

use App\Models\TicketVirtual;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservaCreada extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $reserva;

    public function __construct(TicketVirtual $reserva)
    {
        $this->reserva = $reserva;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function via($notifiable)
    {
        return ['database']; // Puedes agregar 'mail' si quieres enviar correo también
    }

    public function toDatabase($notifiable)
{
    return [
        'user_id' => $this->reserva->user->id ?? null,
        'mensaje' => $this->reserva->user
            ? 'Nueva reserva creada por ' . $this->reserva->user->name
            : 'Usuario no encontrado',
        'nombre_mascota' => 'Nombre de la mascota: ' . ($this->reserva->nombre_mascota ?? 'No especificado'),
        'fecha' => $this->reserva->fecha_cita,
        'hora' => $this->reserva->hora_cita,
        'tipo_servicio' => $this->reserva->servicio->nombre ?? ($this->reserva->servicio->nombre ?? 'Sin especificar'),
        'modelo' => 'ticket_virtual', // <--- CLAVE NECESARIA
    ];
}

    

}
