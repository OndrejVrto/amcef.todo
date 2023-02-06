<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Models\Task;
use App\Enums\OwnerType;
use App\Models\Category;
use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class AdminTaskController {
    public function __invoke(Request $request): View|Factory {
        $validator = Validator::make($request->all(), [
            'owner-type'  => [Rule::enum(OwnerType::class)],
            'task-status' => [Rule::enum(TaskStatus::class)],
            'category'    => [Rule::exists('categories', 'id')],
            'sorting'     => [Rule::in(['title', 'deadline', 'status', 'status_deadline'])],
        ])->valid();

        $filterSorting     = $validator['sorting'] ?? null;
        $filterCategory    = intOrNull($validator['category'] ?? null);
        $filterOwnerType   = intOrNull($validator['owner-type'] ?? null);
        $filterTaskStatuse = intOrNull($validator['task-status'] ?? null);

        $tasks = Task::query()
            ->with('categories')
            ->join('task_user', 'task_user.task_id', '=', 'id')
            ->unless(
                null === $filterCategory,
                fn ($q) => $q
                    ->join('category_task', 'category_task.task_id', '=', 'id')
                    ->where('category_id', $filterCategory)
            )
            ->unless(
                null === $filterOwnerType,
                fn ($q) => $q->where('owner_type', $filterOwnerType)
            )
            ->unless(
                null === $filterTaskStatuse,
                fn ($q) => $q->where('status', $filterTaskStatuse)
            )
            ->where('user_id', auth()->id())
            ->unless(
                null === $filterSorting,
                fn ($q) => $q
                    ->when('title' === $filterSorting, fn (Builder $q) => $q->orderBy('title'))
                    ->when('status' === $filterSorting, fn (Builder $q) => $q->orderBy('status'))
                    ->when('deadline' === $filterSorting, fn (Builder $q) => $q->orderBy('deadline_until'))
                    ->when('status_deadline' === $filterSorting, fn (Builder $q) => $q->orderBy('status')->orderBy('deadline_until')),
                fn ($q) => $q->orderByDesc('id')
            )
            ->withTrashed()
            ->get()
            ->filter(fn (Task $task) => $task->isGuest ? null === $task->deleted_at : true);

        return view('task.index', [
            'tasks' => $tasks,
            'categories' => Category::all(),
            'ownerTypes' => OwnerType::cases(),
            'taskStatuses' => TaskStatus::cases(),
            'filterSorting' => $filterSorting,
            'filterCategory' => $filterCategory,
            'filterOwnerType' => $filterOwnerType,
            'filterTaskStatuse' => $filterTaskStatuse,
            'unreadNotifications' => Auth::user()?->unreadNotifications,
        ]);
    }
}
