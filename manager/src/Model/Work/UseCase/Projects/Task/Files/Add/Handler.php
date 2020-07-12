<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Files\Add;

use App\Model\Flusher;
use App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Work\Entity\Projects\Task\File\Id as FileId;
use App\Model\Work\Entity\Projects\Task\File\Info;
use App\Model\Work\Entity\Projects\Task\Id as TaskId;
use App\Model\Work\Entity\Projects\Task\TaskRepository;

final class Handler
{
    /**
     * @var MemberRepository
     */
    private $members;
    
    /**
     * @var TaskRepository
     */
    private $tasks;
    
    /**
     * @var Flusher
     */
    private $flusher;
    
    public function __construct(MemberRepository $members, TaskRepository $tasks, Flusher $flusher)
    {
        $this->members = $members;
        $this->tasks = $tasks;
        $this->flusher = $flusher;
    }
    
    public function handle(Command $command): void
    {
        $actor = $this->members->get(new MemberId($command->actor));
        $member = $this->members->get(new MemberId($command->member));
        $task = $this->tasks->get(new TaskId($command->id));
    
        foreach ($command->files as $file) {
            $task->addFile(
                $actor,
                new \DateTimeImmutable(),
                FileId::next(),
                new Info(
                    $file->path,
                    $file->name,
                    $file->size
                )
            );
        }
        $this->flusher->flush($task);
    }
}
