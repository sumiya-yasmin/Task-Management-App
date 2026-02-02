<?php
namespace App\TaskManager\Observers;

use App\TaskManager\Models\Task;
interface TaskObserverInterface
{
     public function updated(Task $task): void;
     public function created(Task $task): void;
}