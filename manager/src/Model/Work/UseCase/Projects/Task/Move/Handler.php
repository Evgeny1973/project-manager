<?php


namespace App\Model\Work\UseCase\Projects\Task\Move;

use App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Flusher;
use App\Model\Work\Entity\Projects\Project\Id as ProjectId;
use App\Model\Work\Entity\Projects\Project\ProjectRepository;
use App\Model\Work\Entity\Projects\Task\Id as TaskId;
use App\Model\Work\Entity\Projects\Task\TaskRepository;

class Handler
{
    /**
     * @var TaskRepository
     */
    public $tasks;
    
    /**
     * @var ProjectRepository
     */
    public $projects;
    
    /**
     * @var Flusher
     */
    public $flusher;
    
    /**
     * @var MemberRepository
     */
    private $members;
    
    public function __construct(MemberRepository $members, TaskRepository $tasks, ProjectRepository $projects, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->projects = $projects;
        $this->flusher = $flusher;
        $this->members = $members;
    }
    
    public function handle(Command $command):void
    {
        $actor = $this->members->get(new MemberId($command->actor));
        $task = $this->tasks->get(new TaskId($command->id));
        $project = $this->projects->get(new ProjectId($command->project));
    
        $task->move($actor, new \DateTimeImmutable(), $project);
        
        if ($command->withChildren) {
            $children = $this->tasks->allByParent($task->getId());
            foreach ($children as $child) {
                $child->move($actor, new \DateTimeImmutable(), $project);
            }
        }
        $this->flusher->flush($task);
    }
}
