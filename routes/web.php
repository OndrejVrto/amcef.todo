<?php

declare(strict_types=1);

use App\Http\Controllers\Task;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkNotificationController;

Route::middleware('auth')
    ->group(function (): void {
        Route::get('/', Task\AdminTaskController::class);
        Route::get('task/detail/{task}', Task\DetailTaskController::class);

        Route::get('task/create', Task\CreateTaskController::class);
        Route::post('task/store', Task\StoreTaskController::class);

        Route::get('task/edit/{task}', Task\EditTaskController::class);
        Route::post('task/save/{task}', Task\SaveTaskController::class);

        Route::get('task/share/{task}', Task\ShareTaskController::class);
        Route::post('task/sharesave/{task}', Task\ShareSaveTaskController::class);

        Route::get('task/delete/{task}', Task\DeleteTaskController::class);
        Route::get('task/restore/{task}', Task\RestoreTaskController::class)->withTrashed();
        Route::get('task/forcedelete/{task}', Task\ForceDeleteTaskController::class)->withTrashed();

        Route::post('mark-as-read', MarkNotificationController::class);
    });
