<?php


namespace App\Model\User\UseCase\SignUp\Request;


use App\Model\User\Entity\Email;
use App\Model\User\Entity\User;
use App\Model\User\Entity\UserRepository;
use Ramsey\Uuid\Uuid;

class Handler
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var PasswordHasher
     */
    private $hasher;
    /**
     * @var Flusher
     */
    private $flusher;

    public function __construct(UserRepository $users, PasswordHasher $hasher, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);
    }
}