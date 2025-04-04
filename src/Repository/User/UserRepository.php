<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function existsWithUsername(string $username): bool
    {
        $user = $this->findByUsername($username);

        return $user !== null;
    }

    public function findByUsername(string $username): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
