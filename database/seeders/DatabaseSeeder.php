<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'akash@example.com'],
            [
                'name' => 'akashkumar kundu',
                'password' => bcrypt('password'),
            ]
        );

        if (Task::count() === 0) {
            Task::factory(10)->create();
        }
    }
}
