<?php


namespace App\Model\User\UseCase\Block;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}