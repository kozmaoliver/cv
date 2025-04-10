<?php

declare(strict_types=1);

namespace App\Controller\Cms\Crud;

use App\Controller\Cms\Shared\AbstractCrudController;
use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/skills', name: 'skill_')]
final class SkillController extends AbstractCrudController
{
    public function __construct(
        private readonly SkillRepository $repository,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    protected function getRepository(): SkillRepository
    {
        return $this->repository;
    }

    protected function getEntityClass(): string
    {
        return Skill::class;
    }

    protected function getFormTypeClass(): string
    {
        return SkillType::class;
    }

    protected function getBaseRouteName(): string
    {
        return 'skill_';
    }
}