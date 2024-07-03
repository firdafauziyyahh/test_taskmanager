<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(10)
            ->hasTasks(5) // Setiap user memiliki 5 tugas
            ->create();
    }
}
