<?php


namespace App\Model\User\UseCase\Network;


use App\Model\Flusher;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Flusher
     */
    private $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command)
    {
        if ($this->users->hasByNetworkIdentity($command->network, $command->identity)) {
            throw new \DomainException('Пользователь уже зарегистрирован.');
        }

        $user = new User(Id::next(), new \DateTimeImmutable());
        $user->signUpByNetwork($command->network, $command->identity);
        $this->users->add($user);
        $this->flusher->flush();
    }
}