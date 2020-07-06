<?php


namespace App\Model\Work\UseCase\Projects\Task\Plan\Remove;


use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var int
     */
    public $id;
    
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