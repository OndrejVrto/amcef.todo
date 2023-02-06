<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Enums\OwnerType;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeederFull extends Seeder {
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
        User::factory(7)->create();

        Category::insert([
            ['title' => 'Low'],
            ['title' => 'Medium'],
            ['title' => 'High'],
            ['title' => 'Critical']
        ]);
        Category::factory(6)->create();

        $usersIDs = User::all()->shuffle()->pluck('id');
        $maxUsers = $usersIDs->count();
        $categoriesID = Category::all()->shuffle()->pluck('id');
        $maxCategories = $categoriesID->count();

        Task::factory(50)->create()->each(function (Task $task) use ($usersIDs, $maxUsers, $categoriesID, $maxCategories): void {
            $ownerID = fake()->boolean(20)
                ? 1
                : fake()->numberBetween(1, $maxUsers);
            $task->users()->attach($ownerID, ['owner_type' => OwnerType::OWNER]);

            $guestCount = fake()->numberBetween(0, $maxUsers - 1);
            if ($guestCount > 1) {
                $usersIDs
                    ->filter(fn ($userID) => $userID !== $ownerID)
                    ->shift($guestCount)
                    ->each(function ($guestID) use ($task): void {
                        $task->users()->attach($guestID, ['owner_type' => OwnerType::GUEST]);
                    });
            }

            $categoriesCount = fake()->numberBetween(0, $maxCategories);
            if ($categoriesCount > 0) {
                $categoriesID = fake()->randomElements($categoriesID, $categoriesCount);
                $task->categories()->attach($categoriesID);
            }
        });

        $taskSoftDeleteIDs = Task::all()->shuffle()->pop(20)->pluck('id')->toArray();
        Task::destroy($taskSoftDeleteIDs);
    }
}
