<?php


namespace App\Model\Work\UseCase\Projects\Task\Executor\Assign;

use App\Model\Flusher;
use App\Model\Work\Entity\Projects\Task\Id as TaskId;
use App\Model\Work\Entity\Projects\Task\TaskRepository;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Work\Entity\Members\Member\Id as MemberId;

class Handler
{
    private $tasks;
    private $flusher;
    private $members;
    
    public function __construct(
        TaskRepository $tasks,
        MemberRepository $members,
        Flusher $flusher
    )
    {
        $this->tasks = $tasks;
        $this->flusher = $flusher;
        $this->members = $members;
    }
    
    public function handle(Command $command): void
    {
        $task = $this->tasks->get(new TaskId($command->id));
        
        foreach ($command->members as $id) {
            $member = $this->members->get(new MemberId($id));
            if (!$task->hasExecutor($member->getId())) {
                $task->assignExecutor($member);
            }
        }
        
        $this->flusher->flush();
    }
}