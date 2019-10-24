<?php


namespace App\Command\User;


use App\ReadModel\User\UserFetcher;
use App\Model\User\UseCase\SignUp\Confirm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ConfirmCommand extends Command
{
    /**
     * @var UserFetcher
     */
    private $users;
    /**
     * @var Confirm\Manual\Handler
     */
    private $handler;

    public function __construct(UserFetcher $users, Confirm\Manual\Handler $handler)
    {
        $this->users = $users;
        $this->handler = $handler;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('user:confirm')
            ->setDescription('Подтверждение регистрации пользователя.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $email = $helper->ask($input, $output, new Question('Email: '));

        if (!$user = $this->users->findByEmail($email)) {
            throw new \LogicException('Пользователь не найден.');
        }

        $command = new Confirm\Manual\Command($user->id);
        $this->handler->handle($command);
        $output->writeln('<unfo>Готово!</unfo>');
    }
}