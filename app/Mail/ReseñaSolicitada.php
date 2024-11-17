<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReseñaSolicitada extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $url;

    public function __construct($reserva, $url)
    {
        $this->reserva = $reserva;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('¡Comparte tu experiencia en Hostal La Curva!')
                    ->view('emails.reseña-solicitada');
    }
}