<?php
namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'start_time'  => now()->addDays(rand(1, 30))->format('Y-m-d H:i:s'),
            'end_time'    => now()->addDays(rand(31, 60))->format('Y-m-d H:i:s'),
            'location'    => $this->faker->city,
            'capacity'    => rand(10, 100),
            'status'      => $this->faker->randomElement(['open', 'closed', 'canceled']),
        ];
    }
}
