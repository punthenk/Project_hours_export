<?php

namespace Database\Seeders;

use App\Models\Project;
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
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'punthenk',
            'email' => 'punthenk@laravel.com',
            'password' => bcrypt('password'),
        ]);


        // Projects and tasks
        foreach (range(1, 5) as $i) {
            $project = Project::create([
                'user_id' => $user->id,
                'name' => "Project $i",
                'worked_time' => fake()->randomFloat(2, 0, 40),
            ]);

            foreach (range(1, 5) as $j) {
                Task::create([
                    'project_id' => $project->id,
                    'name' => "Task $j for Project $i",
                    'description' => fake()->sentence(8),
                    'completed' => fake()->boolean(30),
                    'worked_time' => fake()->time('H:i:s', '08:00:00'),
                ]);
            }
        }
    }
}
