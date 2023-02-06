<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RestoreTaskController {
    use AuthorizesRequests;

    public function __invoke(Task $task): RedirectResponse|Redirector {
        $this->authorize('owner', $task);

        $task->restore();

        return redirect(action(AdminTaskController::class));
    }
}
