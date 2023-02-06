<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\OwnerType;
use App\Events\TaskDone;
use App\Notifications\TaskDoneNotification;
use Illuminate\Support\Facades\Notification;

class SendTaskDoneNotification {
    public function handle(TaskDone $event): void {
        $guests = $event->task
            ->users()
            ->where('owner_type', OwnerType::GUEST)
            ->get();

        Notification::send($guests, new TaskDoneNotification($event->task));
    }
}
