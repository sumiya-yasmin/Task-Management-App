<?php
namespace App\TaskManager\Factories;


use App\TaskManager\Models\TaskStatus;
use App\TaskManager\Models\Task;
use DateTimeImmutable;


class TaskFactory
{
    public function create(string $title): Task{
        return new Task($title);

    }
    public function restoreFromStorage(array $data): Task{
        return Task::restore(
            (int) $data['id'],
            $data['title'],
            TaskStatus::from($data['status']),
            new DateTimeImmutable($data['createdAt']),
            $data['endAt']
                ? new DateTimeImmutable($data['endAt'])
                : null

        );
    }
}