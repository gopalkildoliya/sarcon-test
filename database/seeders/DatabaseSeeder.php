<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'email' => 'admin@example.com'
        ]);

        foreach (range(1, 10) as $id) {
            \App\Models\User::factory()->create([
                'email' => "user_${id}@example.com"
            ]);
        }

        $start = now()->hour(10)->minutes(00);

        foreach (range(1, 100) as $id) {
            $time = $start->format('H:ia') . ' ' . $start->addMinutes(45)->format('H:ia');
            \App\Models\EventSession::factory()->create([
                'name' => "Session $id",
                'time' => $time
            ]);
        }
    }
}
