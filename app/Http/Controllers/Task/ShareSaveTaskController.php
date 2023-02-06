<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Models\User;
use App\Enums\OwnerType;
use App\Data\SharingGuests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Notifications\TaskShareNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskUnshareNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShareSaveTaskController {
    use AuthorizesRequests;

    public function __invoke(Request $request, Task $task): RedirectResponse|Redirector {
        $this->authorize('owner', $task);

        $inputGuests = Validator::make($request->collect('guest')->toArray(), [
            'guest'   => ['nullable', 'array'],
            'guest.*' => ['integer', Rule::exists('users', 'id')]
        ])->valid();

        $sharing = $this->handleGuests($task, $inputGuests);

        $task->users()->attach($sharing->attachUsers, ['owner_type' => OwnerType::GUEST]);
        $task->users()->detach($sharing->detachUsers);

        Notification::send($sharing->attachUsers, new TaskShareNotification($task));
        Notification::send($sharing->detachUsers, new TaskUnshareNotification($task));

        return redirect(action(AdminTaskController::class));
    }

    /** @param  array<string,string> $inputListGuests */
    private function handleGuests(Task $task, array $inputListGuests): SharingGuests {
        $ownerID = $this->getTaskOwner($task);

        $oldGuests = $task
            ->users()
            ->where('owner_type', OwnerType::GUEST)
            ->get()
            ->pluck('id');

        $newGuests = Collection::make($inputListGuests)
            ->map(fn ($id) => intOrNull($id))
            ->whereNotNull()
            ->reject(fn ($id) => $id === $ownerID)
            ->unique();

        $detachIDs = $oldGuests->filter(fn ($id) => false === $newGuests->search($id))->values()->toArray();
        $attachIDs = $newGuests->filter(fn ($id) => false === $oldGuests->search($id))->values()->toArray();

        return new SharingGuests (
            attachUsers: User::query()->whereIn('id', $attachIDs)->get(),
            detachUsers: User::query()->whereIn('id', $detachIDs)->get(),
        );
    }

    private function getTaskOwner(Task $task): int {
        return (int) $task
            ->users()
            ->where('owner_type', OwnerType::OWNER)
            ->first()
            ->getAttribute('id');
    }
}
