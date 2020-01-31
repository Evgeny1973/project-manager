<?php


namespace App\Model\Work\UseCase\Projects\Role\Create;


use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $name;

    /**
     * @var string[]
     */
    public $permissions;
}