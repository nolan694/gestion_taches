<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task; // Assurez-vous que cette ligne est présente
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Création de l'admin
        $admin = User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Création de 4 tâches pour l'admin
        Task::factory(4)->for($admin)->create();

        // Création de 4 autres utilisateurs avec chacun 4 tâches
        $users = User::factory(4)->create();

        // Assignation de 4 tâches à chaque utilisateur
        $users->each(function ($user) {
            Task::factory(4)->for($user)->create();
        });
    }
}
