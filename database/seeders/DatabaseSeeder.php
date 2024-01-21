<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Attendee;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Talk;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name'=>'Jareer',
            'email'=>'jareer@email.com',
            'password' => bcrypt(123)
        ]);

        Venue::factory(20)->create();
        Conference::factory(10)->create();
        Speaker::factory(20)->create();
        Talk::factory(30)->create();
        Attendee::factory(10)->create();
    }
}
