<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory {
    /** @return array<string,mixed> */
    public function definition(): array {
        $status = collect(TaskStatus::cases())->pluck('value')->toArray();

        return [
            'title'          => $this->faker->words($this->faker->numberBetween(1, 4), true),
            'description'    => $this->faker->paragraph(),
            'deadline_until' => $this->faker->dateTimeInInterval('now', '+60 days'),
            'status'         => $this->faker->randomElement($status),
        ];
    }
}
