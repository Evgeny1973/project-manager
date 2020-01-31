<?php


namespace App\Model\Work\UseCase\Projects\Role\Copy;


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
}