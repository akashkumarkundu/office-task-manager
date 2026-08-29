<?php

namespace Database\Factories;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teamMembers = [
            'Emon Ahmed',
            'Sarah Jenkins',
            'Tanvir Hasan',
            'Amina Rahman',
            'Rakib Chowdhury',
            'Michael Chang',
            'Fatima Begum',
            'David Miller',
        ];

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'assigned_to' => fake()->randomElement($teamMembers),
            'priority' => fake()->randomElement(['Low', 'Medium', 'High']),
            'status' => fake()->randomElement(['Pending', 'In Progress', 'Completed']),
            'due_date' => fake()->dateTimeBetween('-10 days', '+15 days')->format('Y-m-d'),
        ];
    }
}
