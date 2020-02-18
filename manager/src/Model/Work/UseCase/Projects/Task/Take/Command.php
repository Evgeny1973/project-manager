<?php


namespace App\Model\Work\UseCase\Projects\Task\Take;


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
     * @var string
     */
    public $member;
    
    public function __construct(int $id, string $member)
    {
        $this->id = $id;
        $this->member = $member;
    }
}