<?php


namespace App\Model\Work\UseCase\Projects\Task\TakeAndStart;


use App\Model\Flusher;
use App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Work\Entity\Projects\Task\Id as TaskId;
use App\Model\Work\Entity\Projects\Task\TaskRepository;

class Handler
{
    /**
     * @var TaskRepository
     */
    private $tasks;
    
    /**
     * @var MemberRepository
     */
    private $members;
    
    /**
     * @var Flusher
     */
    private $flusher;
    
    public function __construct(TaskRepository $tasks, MemberRepository $members, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->members = $members;
        $this->flusher = $flusher;
    }
    
    public function handle(Command $command): void
    {
        $actor = $this->members->get(new MemberId($command->actor));
        $task = $this->tasks->get(new TaskId($command->id));
        
        if (!$task->hasExecutor($actor->getId())) {
            $task->assignExecutor($actor, new \DateTimeImmutable(), $actor);
        }
        $task->start($actor, new \DateTimeImmutable());
        $this->flusher->flush($task);
    }
}