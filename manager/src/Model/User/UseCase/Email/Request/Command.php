<?php

namespace App\Model\User\UseCase\Email\Request;

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
     * @Assert\Email()
     * @var string
     */
    public $email;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}