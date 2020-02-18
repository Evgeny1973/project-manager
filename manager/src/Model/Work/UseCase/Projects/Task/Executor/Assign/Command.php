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
    
    public function __construct(int $id)
    {
        $this->id = $id;
    }
}