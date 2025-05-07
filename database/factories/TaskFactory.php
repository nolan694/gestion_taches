<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'due_date' => now()->addDays(rand(1, 30)),
            'status' => fake()->randomElement(['en cours', 'terminée']),
            'user_id' => \App\Models\User::inRandomOrder()->first()->id, // Associe la tâche à un utilisateur aléatoire
        ];
    }
}
