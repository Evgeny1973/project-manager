<?php


namespace App\Model\Work\UseCase\Members\Group\Edit;


use App\Model\Work\Entity\Members\Group\Group;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $id;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $name;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromGroup(Group $group)
    {
        $command = new self($group->getId()->getValue());
        $command->name = $group->getName();
        return $command;
    }
}