<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Http\Controllers\Task\DetailTaskController;

class TaskDoneNotification extends Notification implements ShouldQueue {
    use Queueable;

    private string $url;

    public function __construct(
        private Task $task
    ) {
        $this->url = action(DetailTaskController::class, $task);
    }

    /** @return string[] */
    public function via(mixed $notifiable) {
        return App::isLocal()
            ? ['database']
            : ['database', 'mail'];
    }

    public function toMail(mixed $notifiable): MailMessage {
        return (new MailMessage())
            ->from('amcef.todo@example.com')
            ->subject('Task is DONE: '.$this->task->title)
            ->line('Task "'.$this->task->title.'" is done !')
            ->action('Visit', $this->url)
            ->line('Thank you for using our application!');
    }

    /** @return array<string,mixed> */
    public function toArray(mixed $notifiable): array {
        return [
            'url' => $this->url,
            'id' => $this->task->id,
            'title' => $this->task->title,
        ];
    }
}
