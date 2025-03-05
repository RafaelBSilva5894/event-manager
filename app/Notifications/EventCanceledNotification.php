<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCanceledNotification extends Notification
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🚨 Evento Cancelado: ' . $this->event->title)
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Infelizmente, o evento "' . $this->event->title . '" foi cancelado.')
            ->line('Data de Início: ' . \Carbon\Carbon::parse($this->event->start_time)->format('d/m/Y - H:i'))
            ->line('Local: ' . $this->event->location)
            ->line('Pedimos desculpas pelo transtorno e esperamos vê-lo em outros eventos.')
            ->action('Ver Outros Eventos', url('/events'))
            ->line('Atenciosamente, Equipe Event Manager.');
    }
}
