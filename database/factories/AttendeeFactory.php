<?php

namespace Database\Factories;

use App\Models\Conference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendee>
 */
class AttendeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'ticket_cost' => $this->faker->numberBetween(100, 1000),
            'is_paid' => $this->faker->boolean,
        ];
    }

    public function forConference(Conference $conference): self
    {
        return $this->state([
            'conference_id' => $conference->id,
        ]);
    }
}
