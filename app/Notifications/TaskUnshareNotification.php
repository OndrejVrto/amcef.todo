<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TaskUnshareNotification extends Notification implements ShouldQueue {
    use Queueable;

    public function __construct(
        private Task $task
    ) {
    }

    /** @return string[] */
    public function via(mixed $notifiable): array {
        return App::isLocal()
            ? ['database']
            : ['database', 'mail'];
    }

    public function toMail(mixed $notifiable): MailMessage {
        return (new MailMessage())
            ->from('amcef.todo@example.com')
            ->subject('Task UNshare: '.$this->task->title)
            ->line('Task "'.$this->task->title.'" is no longer shared by you !')
            ->line('You are lucky!');
    }

    /** @return array<string,mixed> */
    public function toArray(mixed $notifiable): array {
        return [
            'title' => $this->task->title,
        ];
    }
}
