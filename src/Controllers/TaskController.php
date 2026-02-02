<?php
namespace App\TaskManager\Controllers;

use App\TaskManager\Services\TaskService;

class TaskController
{
    public function __construct(private TaskService $service) {}

    public function index(): void 
    {
        $tasks = $this->service->getAllTasks();
        require __DIR__ . '/../Views/tasks.php';
    }
    public function create():void{
     $title = trim($_POST['title'] ?? ''); 
     $title = trim($_POST['title']);
    if ($title !== '') {
     $this->service->createTask($title);
     }  
    header('Location: /');
    exit;
    }

    public function done(): void
    {
        $id = $_GET['id'] ?? null;
        if($id){
            $this->service->markTaskAsDone((int)$id);
        }
        header('Location: /');
        exit;
    }

    public function cancel():void{
        $id = $_GET['id'] ?? null;
        if($id){
            $this->service->cancelTask((int)$id);
        }
        header('Location: /');
        exit;
    }
    public function delete():void{
        $id = $_GET['id'] ?? null;
        if($id){
            $this->service->deleteTask((int)$id);
        }
        header('Location: /');
        exit;
    }
}