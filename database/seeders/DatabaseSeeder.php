<?php
namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criando usuários (5 Admins e 10 Participantes)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::factory(10)->create(); // 10 participantes

        // Criando eventos
        Event::factory(5)->create();

        // Criando inscrições SEM DUPLICAÇÃO
        $users  = User::where('role', 'participant')->get();
        $events = Event::all();

        foreach ($users as $user) {
            $event = $events->random(); // Seleciona um evento aleatório

            // Verifica se já existe a inscrição antes de criar
            if (! EventRegistration::where('user_id', $user->id)->where('event_id', $event->id)->exists()) {
                EventRegistration::create([
                    'user_id'  => $user->id,
                    'event_id' => $event->id,
                ]);
            }
        }
    }
}
