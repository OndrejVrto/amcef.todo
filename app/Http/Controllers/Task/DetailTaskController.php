<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DetailTaskController {
    use AuthorizesRequests;

    public function __invoke(Task $task): View|Factory {
        $this->authorize('guest', $task);

        return view('task.show', [
            'task'               => $task,
            'categories'         => Category::all(),
            'selectedCategories' => $task->categories->pluck('id')->unique()->toArray(),
        ]);
    }
}
