<?php


namespace App\Model\Work\UseCase\Projects\Task\Start;


use App\Model\Flusher;
use App\Model\Work\Entity\Projects\Task\Id;
use App\Model\Work\Entity\Projects\Task\TaskRepository;

class Handler
{
    /**
     * @var TaskRepository
     */
    private $tasks;
    
    /**
     * @var Flusher
     */
    private $flusher;
    
    public function __construct(TaskRepository $tasks, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->flusher = $flusher;
    }
    
    public function handle(Command $command): void
    {
        $task = $this->tasks->get(new Id($command->id));
        $task->start(new \DateTimeImmutable());
        
        $this->flusher->flush();
    }
}