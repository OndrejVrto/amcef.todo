<?php

declare(strict_types=1);

namespace App\Enums;

enum OwnerType: int {
    case OWNER = 1;
    case GUEST = 2;

    /** @return array<int|string,mixed>|string|null */
    public function label(): array|string|null {
        return match ($this) {
            self::OWNER => __('app.OwnerType.OWNER'),
            self::GUEST => __('app.OwnerType.GUEST'),
        };
    }
}
