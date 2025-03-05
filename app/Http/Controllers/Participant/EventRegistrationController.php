<?php
namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Notifications\EventRegistrationCanceled;
use App\Notifications\EventRegistrationConfirmed;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    // Listar eventos abertos para inscrição
    public function index()
    {
        $userId = auth()->id();

        $events = Event::where('status', 'open')
            ->withCount('registrations')
            ->get()
            ->map(function ($event) use ($userId) {
                $event->is_registered = $event->registrations()->where('user_id', $userId)->exists();
                $event->has_spots     = $event->registrations_count < $event->capacity;
                return $event;
            });

        return view('participant.events.index', compact('events'));
    }

    // Registrar um usuário em um evento
    public function register($eventId)
    {
        $userId = auth()->id();
        $event  = Event::find($eventId);

        if (! $event) {
            return redirect()->route('events.list')->with('error', 'Evento não encontrado.');
        }

        if ($event->registrations()->count() >= $event->capacity) {
            return redirect()->route('events.list')->with('error', 'Este evento não tem mais vagas disponíveis.');
        }

        if (EventRegistration::where('user_id', $userId)->where('event_id', $eventId)->exists()) {
            return redirect()->route('events.list')->with('error', 'Você já está inscrito neste evento.');
        }

        EventRegistration::create([
            'user_id'  => $userId,
            'event_id' => $eventId,
        ]);

        // Enviar notificação correta
        auth()->user()->notify(new EventRegistrationConfirmed($event));

        return redirect()->route('events.list')->with('success', 'Inscrição realizada com sucesso! Um e-mail foi enviado para você.');
    }

    // Cancelar a inscrição do usuário
    public function unregister($eventId)
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para cancelar uma inscrição.');
        }

        $userId       = auth()->id();
        $event        = Event::find($eventId);
        $registration = EventRegistration::where('user_id', $userId)->where('event_id', $eventId)->first();

        if (! $registration) {
            return back()->with('error', 'Você não está inscrito neste evento.');
        }

        $registration->delete();

        // Enviar notificação correta
        auth()->user()->notify(new EventRegistrationCanceled($event));

        return back()->with('success', 'Inscrição cancelada com sucesso. Um e-mail de cancelamento foi enviado.');
    }

    // Exibir as inscrições do usuário
    public function myRegistrations()
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para ver suas inscrições.');
        }

        $registrations = EventRegistration::where('user_id', auth()->id())->with('event')->get();

        return view('participant.events.my-registrations', compact('registrations'));
    }
}
