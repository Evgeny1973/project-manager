<?php


namespace App\Model\User\Service;


use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\ResetToken;
use Twig\Environment;

class ResetTokenSender
{
    private $mailer;
    private $twig;
    private $from;

    public function __construct(\Swift_Mailer $mailer, Environment $twig, array $from)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->from = $from;
    }

    public function send(Email $email, ResetToken $token): void
    {
        $message = (new \Swift_Message('Сброс пароля.'))
            ->setFrom($this->from)
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/reset.html.twig', [
                'token' => $token
            ]), 'text/html');
        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Невозможно отправить письмо.');
        }
    }
}