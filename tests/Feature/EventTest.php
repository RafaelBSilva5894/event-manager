<?php
namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_create_an_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.events.store'), [
                'title'       => 'Laravel Workshop',
                'description' => 'Evento de aprendizado sobre Laravel',
                'start_time'  => now()->addDays(1),
                'end_time'    => now()->addDays(2),
                'location'    => 'São Paulo',
                'capacity'    => 100,
                'status'      => 'open',
                '_token'      => csrf_token(),
            ])
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', ['title' => 'Laravel Workshop']);
    }

    /** @test */
    public function an_admin_can_edit_an_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();

        $this->actingAs($admin)
            ->put(route('admin.events.update', $event), [
                'title'       => 'Laravel Avançado',
                'description' => 'Curso avançado de Laravel',
                'start_time'  => now()->addDays(3),
                'end_time'    => now()->addDays(4),
                'location'    => 'Rio de Janeiro',
                'capacity'    => 150,
                'status'      => 'open',
                '_token'      => csrf_token(),
            ])
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseHas('events', ['title' => 'Laravel Avançado']);
    }

    /** @test */
    public function an_admin_can_delete_an_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $event = Event::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.events.destroy', $event), ['_token' => csrf_token()])
            ->assertRedirect(route('admin.events.index'));

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function non_admin_cannot_create_an_event()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->post(route('admin.events.store'), [
                'title'       => 'Evento Não Autorizado',
                'description' => 'Este evento não deve ser criado.',
                'start_time'  => now()->addDays(1)->toDateTimeString(),
                'end_time'    => now()->addDays(2)->toDateTimeString(),
                'location'    => 'São Paulo',
                'capacity'    => 100,
                'status'      => 'open',
                '_token'      => csrf_token(),
            ]);

        // Verifica se o acesso foi negado
        $response->assertForbidden();
        $this->assertDatabaseMissing('events', ['title' => 'Evento Não Autorizado']);
    }

    public function non_admin_cannot_edit_an_event()
    {
        $user  = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->put(route('admin.events.update', $event), [
                'title'       => 'Evento Editado Não Autorizado',
                'description' => 'Este evento não deve ser editado.',
                'start_time'  => now()->addDays(3)->toDateTimeString(),
                'end_time'    => now()->addDays(4)->toDateTimeString(),
                'location'    => 'Rio de Janeiro',
                'capacity'    => 150,
                'status'      => 'open',
                '_token'      => csrf_token(),
            ]);

        // Verifica se o acesso foi negado
        $response->assertForbidden();
        $this->assertDatabaseMissing('events', ['title' => 'Evento Editado Não Autorizado']);
    }

    public function non_admin_cannot_delete_an_event()
    {
        $user  = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('admin.events.destroy', $event), [
                '_token' => csrf_token(),
            ]);

        // Verifica se o acesso foi negado
        $response->assertForbidden();
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }
}
