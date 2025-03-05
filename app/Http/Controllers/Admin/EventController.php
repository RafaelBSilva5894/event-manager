<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Notifications\EventCanceledNotification;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Listar eventos
    public function index()
    {
        $events = Event::orderBy('start_time', 'asc')->get();
        return view('admin.events.index', compact('events'));
    }

    // Formulário para criar novo evento
    public function create()
    {
        return view('admin.events.create');
    }

    // Salvar novo evento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'status'      => 'required|in:open,closed,canceled',
        ]);

        // Verifica se há conflito de horário no mesmo local
        $conflictingEvent = Event::where('location', $validated['location'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($conflictingEvent) {
            return redirect()->route('admin.events.create')->with('error', 'Já existe um evento agendado para esse local e horário.');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Evento criado com sucesso.');
    }

    // Mostrar um evento específico
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    // Formulário para editar evento
    public function edit(Event $event)
    {
        // Impedir edição de eventos passados
        if ($event->start_time < now()) {
            return redirect()->route('admin.events.index')->with('error', 'Não é possível editar eventos que já começaram ou foram finalizados.');
        }

        return view('admin.events.edit', compact('event'));
    }

    // Atualizar evento
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'status'      => 'required|in:open,closed,canceled',
        ]);

        // Verificar se o evento foi cancelado e notificar os inscritos
        if ($validated['status'] === 'canceled' && $event->status !== 'canceled') {
            $registrations = $event->registrations;

            foreach ($registrations as $registration) {
                $registration->user->notify(new EventCanceledNotification($event));
            }
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Evento atualizado com sucesso.');
    }

    // Deletar evento
    public function destroy(Event $event)
    {
        // Impedir exclusão de eventos passados
        if ($event->start_time < now()) {
            return redirect()->route('admin.events.index')->with('error', 'Não é possível excluir eventos que já começaram ou foram finalizados.');
        }

        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Evento excluído com sucesso.');
    }

    public function registrations($eventId)
    {
        $event = Event::with('registrations.user')->findOrFail($eventId);

        return view('admin.events.registrations', compact('event'));
    }
}
