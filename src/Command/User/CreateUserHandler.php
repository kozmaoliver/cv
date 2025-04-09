<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Exception\User\UserExistsException;
use App\Factory\UserFactory;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler(handles: CreateUser::class)]
readonly class CreateUserHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Autowire('@app.factory.user')]
        private UserFactory            $userFactory,
        private UserRepository         $userRepository,
        private GoogleAuthenticator    $googleAuthenticator,
        private ValidatorInterface     $validator,
    )
    {
    }

    public function __invoke(CreateUser $createUser): void
    {
        $username = $createUser->email;

        $exists = $this->userRepository->existsWithUsername($username);

        if ($exists) {
            throw new UserExistsException($username);
        }

        $user = $this->userFactory->create($username, $createUser->password);
        $user->setEmail($createUser->email);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setGoogleAuthenticatorSecret($this->googleAuthenticator->generateSecret());

        $violations = $this->validator->validate($user);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($user, $violations);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}