<?php
namespace App\TaskManager\Models;
use DateTimeImmutable;
use LogicException;
use InvalidArgumentException;


Class Task
{
    private ?int $id=null; // added later/new commit after the completion
    private string $title;
    private TaskStatus $status;
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $endAt;

    // public function setTitle(string $title){
    //    $this->title = $title;                //No letting others setting title as the task might not be valid
                                               //Rule: If a field defines what the object is, don’t expose a setter. 
    // }

    public function assignId(int $id): void{
        if($this->id !==null){
            throw new LogicException('Task ID already assigned');
        }
        $this->id= $id;
    }
    // GETTERS (queries)
    public function getId(): ?int {
        return $this->id;
    }
    public function getTitle(): string{
       return $this->title; 
    }
    public function getStatus(): TaskStatus
    {
        return $this->status;
    }
    public function getCreatedAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }
     public function getEndAt() : ?DateTimeImmutable
    {
        return $this->endAt;
    }

    // Methods 

    public function markAsDone(): void{    //methd naming convention: camel casing
        
        if($this->status === TaskStatus::CANCELLED){
            THROW NEW LogicException('Cancelled task cannot be marked as done');
        }
        $this->status = TaskStatus::DONE;
        $this->endAt = new DateTimeImmutable();
    }
    public function Cancel(): void{
        if($this->status === TaskStatus::DONE){
            THROW NEW LogicException('Done task cannot be marked cancelled');
        }
        $this->status = TaskStatus::CANCELLED;
        $this->endAt = new DateTimeImmutable();
    }
   
    //Constructor should enforce minimum valid state, nothing more.
    public function __construct(string $title)
    {
              //validation
              $title = trim($title);
              if($title === ''){
                throw new InvalidArgumentException('Task title cannot be empty');
              }
               $this->title = $title;
               $this->status = TaskStatus::ONGOING;
               $this->createdAt = new DateTimeImmutable();
               $this->endAt = null;

    }


}