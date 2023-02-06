<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Events\TaskDone;
use App\Enums\TaskStatus;
use App\Http\Requests\TaskRequest;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SaveTaskController {
    use AuthorizesRequests;

    public function __invoke(TaskRequest $request, Task $task): RedirectResponse|Redirector {
        $this->authorize('owner', $task);

        $validated = $request->validated();

        if (is_array($validated)) {
            $task->update($validated);
            $task->categories()->sync($validated['categories']);

            if ($this->taskIsDone($validated['status'])) {
                TaskDone::dispatch($task);
            }
        }

        return redirect(action(AdminTaskController::class));
    }

    private function taskIsDone(string $status): bool {
        return intOrNull($status) === TaskStatus::FINISHED->value;
    }
}
