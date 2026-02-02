<?php
namespace App\TaskManager\Observers;

use App\TaskManager\Models\Task;
class LoggerObserver implements TaskObserverInterface{
    public function created(Task $task): void {
        echo "[LOG] New task created: " . $task->getTitle() . PHP_EOL;
    }

    public function updated(Task $task): void {
        echo "[LOG] Task updated: " . $task->getTitle() . " (Status: " . $task->getStatus()->value . ")" . PHP_EOL;
    }
}
