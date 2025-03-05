<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class EventRegistrationConfirmed extends Notification
{
    use Queueable;

    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmação de Inscrição no Evento')
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('Sua inscrição no evento "' . $this->event->title . '" foi confirmada.')
            ->line('🗓 Data: ' . Carbon::parse($this->event->start_time)->format('d/m/Y - H:i'))
            ->line('📍 Local: ' . $this->event->location)
            ->action('Ver evento', url('/events'))
            ->line('Obrigado por se inscrever!');
    }
}
