<?php
namespace App\TaskManager\Repositories;
use App\TaskManager\Models\Task;
use App\TaskManager\Models\TaskStatus;
use  App\TaskManager\Interfaces\TaskRepositoryInterface;
use App\TaskManager\Factories\TaskFactory;

use DateTimeImmutable;
use InvalidArgumentException;
use RuntimeException;
class FileTaskRepository implements TaskRepositoryInterface{
      private string $filepath;
      private TaskFactory $factory;

      public function save(Task $task): void{
         $data= $this->readData();
         if($task->getId() === null){
            $id = empty($data) ? 1 : max(array_keys($data))+1;
            $task->assignId((int) $id);
         }
         $data[$task->getId()]=
         [
            'id'=>$task->getId(),
            'title' =>$task->getTitle(),
            'status'=>$task->getStatus()->value,
            'createdAt'=> $task->getCreatedAt()->format(DATE_ATOM),
            'endAt'=> $task->getEndAt()?->format(DATE_ATOM),
         ];
         $this->writeData($data);


      }
      public function findById(int $id): ?Task{
          $data= $this-> readData();
          return isset($data[$id]) ? $this->hydrate($data[$id]) : null;
      }
      public function findAll():array{
          $tasks = [];
          foreach($this->readData() as $row){
            $tasks[] = $this->hydrate($row);
          }
          return $tasks;
      }
      public function delete(Task $task): void{
          $data=$this->readData();
          unset($data[$task->getId()]);
          $this->writeData($data);
      }
      private function readData(): array{
          $jsonInputs = file_get_contents($this->filepath);
          $data=json_decode($jsonInputs, true);
          if(json_last_error()!==JSON_ERROR_NONE){
            throw new RuntimeException('Corrupted JSON: ' . json_last_error_msg());
            
          }

          return $data ?? [];
      }

      private function writeData(array $data): void{
         file_put_contents($this->filepath, json_encode($data, JSON_PRETTY_PRINT));
      }

      private function hydrate(array $row): Task{
        return $this->factory->restoreFromStorage($row);
        //    $task= new Task($row['title']);
        //    $task->assignId($row['id']);
        //     if($row['status'] === TaskStatus::DONE->value){
        //         $task->markAsDone();
        //     }
        //     if($row['status']===TaskStatus::CANCELLED->value){
        //         $task->cancel();
        //     }
        //     return $task;
      }

      public function __construct(string $filepath, TaskFactory $factory){
             $this->filepath = $filepath;
             $this->factory=$factory;
             $dir = dirname($filepath);
             if(!is_dir($dir)){
                mkdir($dir, recursive:true);
             }
             if (!file_exists($filepath)){
                                file_put_contents($filepath, json_encode([]));
             }
                if(!is_file($filepath) || !is_readable($filepath) || !is_writable($filepath)){
                    throw new InvalidArgumentException("File Path is not valid");
                }

      }
      
}