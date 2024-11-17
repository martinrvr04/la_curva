<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reserva;

class SolicitudReseña extends Notification
{
    use Queueable;

    protected $reserva;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('resenas.create', ['reserva' => $this->reserva]); // Ajusta la ruta

        return (new MailMessage)
                    ->subject('¡Cuéntanos tu experiencia en Hostal La Curva!')
                    ->greeting('Hola ' . $this->reserva->nombre . ',')
                    ->line('Esperamos que hayas disfrutado tu estancia en Hostal La Curva.')
                    ->line('Nos gustaría conocer tu opinión sobre tu experiencia.')
                    ->action('Escribir reseña', $url)
                    ->line('Gracias por tu tiempo.');
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
}