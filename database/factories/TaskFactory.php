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

        $categories = ['Development', 'UI/UX Design', 'DevOps', 'QA Testing', 'Marketing', 'Finance', 'Security', 'Research'];
        $tagsPool = ['Frontend', 'Backend', 'API', 'Bug', 'Urgent', 'Release-v2', 'Optimization', 'Security', 'Client'];

        return [
            'is_pinned' => fake()->boolean(20),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(2),
            'assigned_to' => fake()->randomElement($teamMembers),
            'category' => fake()->randomElement($categories),
            'tags' => implode(', ', fake()->randomElements($tagsPool, rand(1, 3))),
            'priority' => fake()->randomElement(['Low', 'Medium', 'High', 'Urgent']),
            'status' => fake()->randomElement(['Pending', 'In Progress', 'Completed']),
            'due_date' => fake()->dateTimeBetween('-10 days', '+15 days')->format('Y-m-d'),
            'estimated_hours' => fake()->numberBetween(4, 40),
            'spent_hours' => fake()->randomFloat(1, 0, 35),
        ];
    }
}
