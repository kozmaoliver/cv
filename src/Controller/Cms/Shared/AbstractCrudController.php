<?php

declare(strict_types=1);

namespace App\Controller\Cms\Shared;

use App\Entity\Shared\Contracts\EntityInterface;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

abstract class AbstractCrudController extends AbstractController
{
    protected const string FORM_TWIG_PATH = 'cms/crud/form.html.twig';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    abstract protected function getRepository(): ServiceEntityRepositoryInterface;
    abstract protected function getEntityClass(): string;
    abstract protected function getFormTypeClass(): string;
    abstract protected function getBaseRouteName(): string;

    #[Route(name: 'index', methods: ['GET'])]
    public function indexAction(): Response
    {
        $skills = $this->getRepository()->findAll();

        dd($skills); // TODO: datatable?
    }

    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $entity = new ($this->getEntityClass());

        return $this->handleForm($request, $entity);
    }

    #[Route(path: '/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, Skill $skill): Response
    {
        return $this->handleForm($request, $skill);
    }

    protected function handleForm(Request $request, EntityInterface $entity): Response
    {
        $form = $this->createForm($this->getFormTypeClass(), $entity);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->render(self::FORM_TWIG_PATH, [
                'form' => $form,
                'entity' => $entity,
            ]);
        }

        if (!$form->isValid()) {
            return $this->render(self::FORM_TWIG_PATH, [
                'form' => $form,
                'entity' => $entity,
            ]);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $this->redirectToRoute('cms_' . $this->getBaseRouteName() . 'edit', ['id' => $entity->getId()]);
    }

}