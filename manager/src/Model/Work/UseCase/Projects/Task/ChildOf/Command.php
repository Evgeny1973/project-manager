<?php

namespace App\Model\Work\UseCase\Projects\Task\ChildOf;

use App\Model\Work\Entity\Projects\Task\Task;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var int
     */
    public $id;
    
    public $parent;
    
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
        $command->parent = $task->getParent() ? $task->getParent()->getId()->getValue() : null;
        
        return $command;
    }
}
