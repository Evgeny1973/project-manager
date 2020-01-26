<?php


namespace App\Model\Work\UseCase\Projects\Project\Edit;


use App\Model\Work\Entity\Projects\Project\Project;
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

    /**
     * @Assert\NotBlank()
     * @var integer
     */
    public $sort;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromProject(Project $project): self
    {
        $command = new self($project->getId()->getValue());
        $command->name = $project->getName();
        $command->sort = $project->getSort();
        return $command;
    }
}