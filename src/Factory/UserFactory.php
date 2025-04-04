<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\User\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function create(string $username, string $password): User
    {
        $user = new User();

        $user->setEmail($username);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        return $user;
    }
}