<?php


namespace App\Model\Work\UseCase\Projects\Project\Membership\Remove;


use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $project;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $member;

    public function __construct(string $project, string $member)
    {
        $this->project = $project;
        $this->member = $member;
    }
}