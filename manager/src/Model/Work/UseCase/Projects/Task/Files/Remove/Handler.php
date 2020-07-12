<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Files\Remove;

use App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Flusher;
use App\Model\Work\Entity\Projects\Task\File\Id as FileId;
use App\Model\Work\Entity\Projects\Task\Id as TaskId;
use App\Model\Work\Entity\Projects\Task\TaskRepository;

final class Handler
{
    /**
     * @var TaskRepository
     */
    private $tasks;
    
    /**
     * @var Flusher
     */
    private $flusher;
    
    /**
     * @var MemberRepository
     */
    private $members;
    
    public function __construct(MemberRepository $members, TaskRepository $tasks, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->flusher = $flusher;
        $this->members = $members;
    }
    
    public function handle(Command $command): void
    {
        $actor = $this->members->get(new MemberId($command->actor));
        $task = $this->tasks->get(new TaskId($command->id));
    
        $task->removeFile($actor, new \DateTimeImmutable(), new FileId($command->file));
        
        $this->flusher->flush($task);
    }
}
