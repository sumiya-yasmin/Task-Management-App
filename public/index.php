<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\TaskManager\Repositories\FileTaskRepository;
use App\TaskManager\Services\TaskService;
use App\TaskManager\Factories\TaskFactory;
use App\TaskManager\Observers\LoggerObserver;
use App\TaskManager\Controllers\TaskController;



$taskFactory = new TaskFactory();
$repo = new FileTaskRepository(__DIR__. '/storage/tasks.json', $taskFactory);
$service=new TaskService($repo, $taskFactory);
$logger = new LoggerObserver();
$service->addObserver($logger);
$controller = new TaskController($service);

$action = $_GET['action'] ?? 'index';

match ($action) {
    'create' => $controller->create(),
    'done'   => $controller->done(),
    'cancel' => $controller->cancel(),
    'delete' => $controller->delete(),
    default  => $controller->index(),
};


