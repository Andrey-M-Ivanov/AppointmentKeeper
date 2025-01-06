<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "client_id"=>Client::inRandomOrder()->first()->id,
            "date"=>$this->faker->date($format = 'm-d-Y'),
            "time"=>$this->faker->time($format = 'H:i'),
            "description"=>$this->faker->text(100)

        ];
    }
}
