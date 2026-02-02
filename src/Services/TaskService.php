<?php
namespace App\TaskManager\Services;
use App\TaskManager\Models\Task;
use App\TaskManager\Interfaces\TaskRepositoryInterface;
use App\TaskManager\Factories\TaskFactory;

use RunTimeException;
class TaskService{
    private TaskRepositoryInterface $repository;
    private TaskFactory $factory;

    public function createTask(string $title): Task{
        $task = $this->factory->create($title);
        $this->repository->save($task);
        return $task;
    }
    public function markTaskAsDone(int $id):void{
         $task=$this->repository->findById($id);
         if(!$task){
            throw new RunTimeException("Task not found");
         }
         $task->markAsDone();
         $this->repository->save($task);
    }
    public function cancelTask(int $id):void{
        $task=$this->repository->findById($id);
        if(!$task){
            throw new RunTimeException("Task not found");
         }
         $task->cancel();
         $this->repository->save($task);
    }
    public function deleteTask(int $id): void{
        $task=$this->repository->findById($id);
         if(!$task){
            throw new RunTimeException("Task not found");
         }
         $this->repository->delete($task);
    }
    public function getTask(int $id):?Task{
       return $this->repository->findById($id);
    }
    public function getAllTasks(): array{
        return $this->repository->findAll();
    }

    public function __construct(TaskRepositoryInterface $repository, TaskFactory $factory
){
         $this->repository = $repository;
         $this->factory = $factory;
    }
}