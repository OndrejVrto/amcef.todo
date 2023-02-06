<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeederBasic extends Seeder {
    use WithoutModelEvents;

    public function run(): void {
        User::factory()->create([
            'name' => 'Ondrej',
            'email' => 'ondrej@example.com',
        ]);

        User::factory()->create([
            'name' => 'Samuel',
            'email' => 'samuel@example.com',
        ]);

        User::factory()->create([
            'name' => 'Milan',
            'email' => 'milan@example.com',
        ]);

        Category::insert([
            ['title' => 'Low'],
            ['title' => 'Medium'],
            ['title' => 'High'],
            ['title' => 'Critical']
        ]);
    }
}
