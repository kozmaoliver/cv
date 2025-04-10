<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\WorkExperience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WorkExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkExperience::class);
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('w')
            ->orderBy('w.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }

}