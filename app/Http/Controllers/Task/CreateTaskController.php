<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Category;
use App\Enums\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class CreateTaskController {
    public function __invoke(): View|Factory {
        return view('task.create', [
            'categories'   => Category::all(),
            'taskStatuses' => TaskStatus::cases(),
        ]);
    }
}
