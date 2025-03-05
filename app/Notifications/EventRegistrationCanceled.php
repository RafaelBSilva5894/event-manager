<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class EventRegistrationCanceled extends Notification
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
            ->subject('Cancelamento de Inscrição no Evento')
            ->greeting('Olá ' . $notifiable->name . '!')
            ->line('Sua inscrição no evento "' . $this->event->title . '" foi cancelada.')
            ->line('🗓 Data: ' . Carbon::parse($this->event->start_time)->format('d/m/Y - H:i'))
            ->line('📍 Local: ' . $this->event->location)
            ->line('Caso tenha sido um engano, você pode se inscrever novamente.')
            ->action('Ver eventos', url('/events'))
            ->line('Esperamos vê-lo em outros eventos!');
    }
}
