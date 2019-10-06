<?php


namespace App\Model\User\UseCase\Reset;


use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\ResetTokenSender;
use App\Model\User\Service\ResetTokenizer;

class Handler
{
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var ResetTokenizer
     */
    private $tokinizer;
    /**
     * @var Flusher
     */
    private $flusher;
    /**
     * @var ResetTokenSender
     */
    private $sender;

    public function __construct(
        UserRepository $users,
        ResetTokenizer $tokinizer,
        Flusher $flusher,
        ResetTokenSender $sender
    )
    {
        $this->users = $users;
        $this->tokinizer = $tokinizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    private function handle(Command $command): void
    {
        $user = $this->users->getNyEmail(new Email($command->email));

        $user->requestPasswordReset($this->tokinizer->generate(), new \DateTimeImmutable);
        $this->flusher->flush();
        $this->sender->send($user->getEmail(), $user->getResetToken());
    }
}