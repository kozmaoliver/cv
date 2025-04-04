<?php

declare(strict_types=1);

namespace App\Console;

use App\Command\User\CreateUser;
use App\Exception\User\UserExistsException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: self::NAME, description: 'Create a new admin.')]
class CreateAdminCommand extends Command
{
    private const string NAME = 'app:create-admin';

    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
        parent::__construct(self::NAME);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email address for admin user')
            ->addArgument('password', InputArgument::REQUIRED, 'Password address for admin user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $message = new CreateUser(
            $input->getArgument('email'),
            $input->getArgument('password'),
        );

        try {
            $this->messageBus->dispatch($message);
        } catch (HandlerFailedException $exception) {
            $cause = $exception->getPrevious();

            if ($cause instanceof UserExistsException) {
                $io->error(sprintf('User already exists: %s', $cause->getUsername()));
                return self::FAILURE;
            }

            $io->error($cause->getMessage());
            return self::FAILURE;
        }

        $io->success('User is created!');

        return self::SUCCESS;
    }
}