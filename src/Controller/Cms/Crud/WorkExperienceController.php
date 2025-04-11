<?php

declare(strict_types=1);

namespace App\Controller\Cms\Crud;

use App\Controller\Cms\Shared\AbstractCrudController;
use App\Entity\WorkExperience;
use App\Form\WorkExperienceType;
use App\Repository\WorkExperienceRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/work-experiences', name: 'work_experience_')]
class WorkExperienceController extends AbstractCrudController
{
    protected const string FORM_TWIG_PATH = 'cms/crud/default_form.html.twig';

    public function __construct(
        private readonly WorkExperienceRepository $repository,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct($entityManager);
    }

    protected function getRepository(): ServiceEntityRepositoryInterface
    {
        return $this->repository;
    }

    protected function getEntityClass(): string
    {
        return WorkExperience::class;
    }

    protected function getFormTypeClass(): string
    {
        return WorkExperienceType::class;
    }

    protected function getBaseRouteName(): string
    {
        return 'work_experience_';
    }
}