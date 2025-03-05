<?php
namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventRegistrationConfirmed;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_for_an_event()
    {
        $user  = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 10]);

        $response = $this->actingAs($user)
            ->post(route('events.register', $event->id), [
                '_token' => csrf_token(),
            ]);

        // Verifica o redirecionamento para a lista de eventos
        $response->assertRedirect(route('events.list'));
        $response->assertSessionHas('success', 'Inscrição realizada com sucesso! Um e-mail foi enviado para você.');

        // Verifica se o registro foi criado no banco de dados
        $this->assertDatabaseHas('event_registrations', [
            'user_id'  => $user->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_user_cannot_register_if_event_is_full()
    {
        $event = Event::factory()->create(['capacity' => 1]);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Registra o primeiro usuário no evento
        EventRegistration::create(['user_id' => $user1->id, 'event_id' => $event->id]);

        // Tenta registrar o segundo usuário no evento
        $response = $this->actingAs($user2)
            ->post(route('events.register', $event->id), [
                '_token' => csrf_token(),
            ]);

        // Verifica o redirecionamento para a lista de eventos
        $response->assertRedirect(route('events.list'));
        $response->assertSessionHas('error', 'Este evento não tem mais vagas disponíveis.');

        // Verifica se o segundo usuário não foi registrado
        $this->assertDatabaseMissing('event_registrations', [
            'user_id'  => $user2->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_user_cannot_register_if_already_registered()
    {
        $user  = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 10]);

        // Registra o usuário no evento
        EventRegistration::create(['user_id' => $user->id, 'event_id' => $event->id]);

        // Tenta registrar o mesmo usuário novamente
        $response = $this->actingAs($user)
            ->post(route('events.register', $event->id), [
                '_token' => csrf_token(),
            ]);

        // Verifica o redirecionamento para a lista de eventos
        $response->assertRedirect(route('events.list'));
        $response->assertSessionHas('error', 'Você já está inscrito neste evento.');

        // Verifica se não há duplicação de registros
        $this->assertCount(1, EventRegistration::where('user_id', $user->id)->where('event_id', $event->id)->get());
    }
    public function user_can_cancel_registration()
    {
        $user         = User::factory()->create();
        $event        = Event::factory()->create();
        $registration = EventRegistration::create([
            'user_id'  => $user->id,
            'event_id' => $event->id,
        ]);

        // Cancela a inscrição
        $response = $this->actingAs($user)
            ->delete(route('events.unregister', $event->id), [
                '_token' => csrf_token(),
            ]);

        // Verifica o redirecionamento e a mensagem de sucesso
        $response->assertRedirect(route('events.myRegistrations'));
        $response->assertSessionHas('success', 'Inscrição cancelada com sucesso!');

        // Verifica se o registro foi removido do banco de dados
        $this->assertDatabaseMissing('event_registrations', [
            'user_id'  => $user->id,
            'event_id' => $event->id,
        ]);
    }

    public function user_receives_email_notification_after_registering_for_an_event()
    {
        // Configura o driver de e-mail como "log" para evitar erros de SMTP
        Notification::fake();

        $user  = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 10]);

        // Registra o usuário no evento
        $response = $this->actingAs($user)
            ->post(route('events.register', $event->id), [
                '_token' => csrf_token(),
            ]);

        // Verifica se a notificação foi enviada
        Notification::assertSentTo(
            $user,
            EventRegistrationConfirmed::class,
            function ($notification, $channels) use ($event) {
                return $notification->event->id === $event->id;
            }
        );

        // Verifica o redirecionamento e a mensagem de sucesso
        $response->assertRedirect(route('events.list'));
        $response->assertSessionHas('success', 'Inscrição realizada com sucesso! Um e-mail foi enviado para você.');
    }
}
