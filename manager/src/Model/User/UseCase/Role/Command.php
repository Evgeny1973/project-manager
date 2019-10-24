<?php


namespace App\Model\User\UseCase\Role;

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
    public $role;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}