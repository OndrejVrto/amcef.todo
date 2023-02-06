<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: int {
    case INPROGRESS = 1;
    case OPEN       = 2;
    case FINISHED   = 3;

    /** @return array<int|string,mixed>|string|null */
    public function label(): array|string|null {
        return match ($this) {
            self::INPROGRESS => __('app.TaskStatus.INPROGRESS'),
            self::OPEN       => __('app.TaskStatus.OPEN'),
            self::FINISHED   => __('app.TaskStatus.FINISHED'),
        };
    }

    public function icon(): string {
        return match ($this) {
            self::INPROGRESS => 'fa-solid fa-spinner fa-lg text-warning',
            self::OPEN       => 'fa-regular fa-times-circle fa-lg text-danger',
            self::FINISHED   => 'fa-solid fa-check fa-lg text-success',
        };
    }
}
