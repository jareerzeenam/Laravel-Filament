<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Speaker;
use App\Models\Talk;

class TalkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Talk::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $randomSpeakerId = Speaker::inRandomOrder()->value('id');
        return [
            'name' => $this->faker->name(),
            'abstract' => $this->faker->text(),
            'speaker_id' => $randomSpeakerId,
        ];
    }
}
