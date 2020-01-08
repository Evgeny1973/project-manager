<?php


namespace App\Model\User\UseCase\Create;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\PasswordGenerator;
use App\Model\User\Service\PasswordHasher;

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
     * @var PasswordGenerator
     */
    private $generator;
    /**
     * @var Flusher
     */
    private $flusher;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        PasswordGenerator $generator,
        Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->generator = $generator;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('Пользователь с таким email уже есть.');
        }

        $user = User::create(
            Id::next(),
            new \DateTimeImmutable(),
            new Name(
                $command->firstName,
                $command->lastName
            ),
            $email,
            $this->hasher->hash($this->generator->generate())
        );

        $this->users->add($user);
        $this->flusher->flush();
    }
}