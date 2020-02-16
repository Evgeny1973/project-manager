<?php


namespace App\Model\Work\UseCase\Projects\Task\Move;


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
    
    public function __construct(TaskRepository $tasks, ProjectRepository $projects, Flusher $flusher)
    {
        $this->tasks = $tasks;
        $this->projects = $projects;
        $this->flusher = $flusher;
    }
    
    public function handle(Command $command):void
    {
        $task = $this->tasks->get(new TaskId($command->id));
        $project = $this->projects->get(new ProjectId($command->project));
        
        $task->move($project);
        
        if ($command->withChildren) {
            $children = $this->tasks->allByParent($task->getId());
            foreach ($children as $child) {
                $child->move($project);
            }
        }
        $this->flusher->flush();
    }
}