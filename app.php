<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\TaskManager\Repositories\FileTaskRepository;
use App\TaskManager\Services\TaskService;
use App\TaskManager\Factories\TaskFactory;


$taskFactory = new TaskFactory();
$repo = new FileTaskRepository(__DIR__. '/storage/tasks.json', $taskFactory);
$service=new TaskService($repo, $taskFactory);

$command= $argv[1] ?? null;
switch ($command) {
    case 'create':
        $title = $argv[2] ?? '';
        $task = $service->createTask($title);
        echo "Task created with ID: {$task->getId()}" . PHP_EOL;
        break;

    case 'list':
        foreach ($service->getAllTasks() as $task) {
            echo "{$task->getId()} | {$task->getTitle()} | {$task->getStatus()->value}" . PHP_EOL;
        }
        break;

    case 'done':
        $service->markTaskAsDone((int)$argv[2]);
        echo "Task marked as done" . PHP_EOL;
        break;

    case 'cancel':
        $service->cancelTask((int)$argv[2]);
        echo "Task cancelled" . PHP_EOL;
        break;

    case 'delete':
        $service->deleteTask((int)$argv[2]);
        echo "Task deleted" . PHP_EOL;
        break;

    default:
        echo "Unknown command" . PHP_EOL;
}
