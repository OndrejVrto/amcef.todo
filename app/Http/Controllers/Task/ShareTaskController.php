<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Models\User;
use App\Enums\OwnerType;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShareTaskController {
    use AuthorizesRequests;

    public function __invoke(Task $task): View|Factory {
        $this->authorize('owner', $task);

        $users = User::all()
            ->filter(fn ($user) => $user->id !== auth()->id());

        $guests = $task
            ->users()
            ->wherePivot('owner_type', '=', OwnerType::GUEST)
            ->get()
            ->pluck('id');

        return view('task.share-edit', [
            'task' => $task,
            'users' => $users,
            'guests' => $guests,
        ]);
    }
}
