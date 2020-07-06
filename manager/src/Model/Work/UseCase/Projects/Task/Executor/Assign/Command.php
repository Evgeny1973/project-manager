<?php


namespace App\Model\Work\UseCase\Projects\Task\Executor\Assign;


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
     * @var array
     */
    public $members;
    
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
}
