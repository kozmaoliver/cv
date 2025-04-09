<?php

namespace App\Console;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\ConsoleWriter;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: self::NAME, description: 'Show 2FA QR code for an admin')]
class ShowAdmin2faCommand extends Command
{
    private const string NAME = 'app:admin:show-2fa';

    public function __construct(
        private readonly UserRepository         $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly GoogleAuthenticator    $googleAuthenticator,
    )
    {
        parent::__construct(self::NAME);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email address for admin user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $io->error(sprintf('User do not exists: %s', $email));
            return self::FAILURE;
        }

        /** @var User $user */
        if (null === $user->getGoogleAuthenticatorSecret()) {
            $user->setGoogleAuthenticatorSecret($this->googleAuthenticator->generateSecret());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $builder = new Builder();

        $qrCode = $builder->build(
            new ConsoleWriter(),
            data: $this->googleAuthenticator->getQRContent($user)
        );

        $io->write($qrCode->getString());

        return self::SUCCESS;
    }
}