<?php


namespace App\Model\User\UseCase\SignUp\Request;


use App\Model\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function handle(Command $command): void
    {
        $email = mb_strtolower($command->email);

        if ($this->em->getRepository(User::class)->findOneBy(['email' => $email])) {
            throw new \DomainException('Такой пользователь уже есть');
        }
        $user = new User($email, password_hash($command->password, PASSWORD_ARGON2I));
        $this->em->persist($user);
        $this->em->flush();
    }
}