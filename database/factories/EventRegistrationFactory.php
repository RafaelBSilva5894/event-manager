<?php
namespace Database\Factories;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventRegistrationFactory extends Factory
{
    protected $model = EventRegistration::class;

    public function definition()
    {
        // Obtém usuários e eventos aleatórios
        $user  = User::inRandomOrder()->first() ?? User::factory()->create();
        $event = Event::inRandomOrder()->first() ?? Event::factory()->create();

        // Verifica se o usuário já está inscrito no evento
        $existingRegistration = EventRegistration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($existingRegistration) {
            return [];
        }

        return [
            'user_id'  => $user->id,
            'event_id' => $event->id,
        ];
    }
}
