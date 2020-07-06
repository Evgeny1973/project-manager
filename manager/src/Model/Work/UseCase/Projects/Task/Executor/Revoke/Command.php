<?php


namespace App\Model\Work\UseCase\Projects\Task\Executor\Revoke;


use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $member;
    
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $actor;
    
    public function __construct(string $actor, int $id, string $member)
    {
        $this->id = $id;
        $this->member = $member;
        $this->actor = $actor;
    }
}