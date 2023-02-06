<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        Category::insert([
            ['title' => 'Low'],
            ['title' => 'Medium'],
            ['title' => 'High'],
            ['title' => 'Critical']
        ]);
    }
}
