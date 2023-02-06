<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Enums\OwnerType;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool {
        return true;
    }

    public function create(User $user): Response|bool {
        return true;
    }

    public function guest(User $user, Task $task): Response|bool {
        return null !== $task->users()
            ->where('user_id', $user->id)
            ->first();
    }

    public function owner(User $user, Task $task): Response|bool {
        return null !== $task->users()
            ->where('user_id', $user->id)
            ->where('owner_type', OwnerType::OWNER)
            ->first();
    }
}
