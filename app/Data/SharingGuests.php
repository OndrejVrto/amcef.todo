<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Support\Collection;

class SharingGuests {
    /**
     * @param  Collection<User> $attachUsers
     * @param  Collection<User> $detachUsers
     */
    public function __construct(
        public readonly Collection $attachUsers,
        public readonly Collection $detachUsers,
    ) {
    }
}
