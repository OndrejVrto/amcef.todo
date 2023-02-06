<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory {
    /** @return array<string,mixed> */
    public function definition(): array {
        return [
            'title' => $this->faker->word(),
        ];
    }
}
