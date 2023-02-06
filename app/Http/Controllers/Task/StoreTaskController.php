<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Enums\OwnerType;
use App\Http\Requests\TaskRequest;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class StoreTaskController {
    public function __invoke(TaskRequest $request): RedirectResponse|Redirector {
        $validated = $request->validated();

        if (is_array($validated)) {
            $task = Task::create($validated);
            $task->users()->attach(auth()->id(), ['owner_type' => OwnerType::OWNER]);
            $task->categories()->attach($validated['categories']);
        }

        return redirect(action(AdminTaskController::class));
    }
}
