<?php


namespace App\Model\User\UseCase\SignUp\Request;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Name;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\SignUpConfirmTokenSender;
use App\Model\User\Service\SignUpConfirmTokinizer;
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
     * @var Flusher
     */
    private $flusher;
    /**
     * @var SignUpConfirmTokinizer
     */
    private $tokinizer;
    /**
     * @var SignUpConfirmTokenSender
     */
    private $sender;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        SignUpConfirmTokinizer $tokinizer,
        SignUpConfirmTokenSender $sender,
        Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
        $this->tokinizer = $tokinizer;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new \DomainException('Такой пользователь уже зарегистрирован.');
        }

        $user = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable,
            new Name(
                $command->firstName,
                $command->lastName),
            $email,
            $this->hasher->hash($command->password),
            $token = $this->tokinizer->generate()
        );
        $this->users->add($user);
        $this->sender->send($email, $token);
        $this->flusher->flush();
    }
}
