<?php


namespace App\Model\Work\UseCase\Projects\Task\Priority;


use App\Model\Work\Entity\Projects\Task\Task;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var int
     */
    public $id;
    
    /**
     * @Assert\NotBlank()
     */
    public $priority;
    
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $actor;
    
    public function __construct(string $actor, int $id)
    {
        $this->id = $id;
        $this->actor = $actor;
    }
    
    public static function fromTask(string $actor, Task $task): self
    {
        $command = new self($actor, $task->getId()->getValue());
        $command->priority = $task->getPriority();
        
        return $command;
    }
}
