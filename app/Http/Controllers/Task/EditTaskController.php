<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Models\Category;
use App\Enums\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditTaskController {
    use AuthorizesRequests;

    public function __invoke(Task $task): View|Factory {
        $this->authorize('owner', $task);

        return view('task.edit', [
            'task'               => $task,
            'categories'         => Category::all(),
            'taskStatuses'       => TaskStatus::cases(),
            'selectedCategories' => $task->categories->pluck('id')->unique()->toArray(),
        ]);
    }
}
