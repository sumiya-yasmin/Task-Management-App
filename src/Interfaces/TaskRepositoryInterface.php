<?php
namespace App\TaskManager\Interfaces;
use App\TaskManager\Models\Task;
interface TaskRepositoryInterface
{
    public function save(Task $task): void;
    public function findById(int $id): ?Task;
    public function findAll(): array;
    public function delete(Task $task): void;
}