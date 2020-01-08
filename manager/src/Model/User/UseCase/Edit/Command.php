<?php


namespace App\Model\User\UseCase\Edit;

use App\Model\User\Entity\User\User;
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
     */
    public $email;

    /**
     * @Assert\NotBlank()
     */
    public $firstName;

    /**
     * @Assert\NotBlank()
     */
    public $lastName;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromUser(User $user): self
    {
        $commamd = new self($user->getId()->getValue());
        $commamd->email = $user->getEmail() ? $user->getEmail()->getValue() : null;
        $commamd->firstName = $user->getName()->getFirst();
        $commamd->lastName = $user->getName()->getLast();
        return $commamd;
    }
}