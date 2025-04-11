<?php

declare(strict_types=1);

namespace App\Controller\Cms\Shared;

use App\Entity\Shared\Contracts\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

abstract class AbstractCrudController extends AbstractController
{
    protected const string list_TWIG_PATH = 'cms/crud/list.html.twig';
    protected const string FORM_TWIG_PATH = 'cms/crud/default_form.html.twig';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    abstract protected function getRepository(): ServiceEntityRepositoryInterface;

    abstract protected function getEntityClass(): string;

    abstract protected function getFormTypeClass(): string;

    abstract protected function getBaseRouteName(): string;

    #[Route(name: 'index', methods: ['GET'])]
    public function indexAction(): Response
    {
        $entities = $this->getRepository()->findAll();

        return $this->render(static::list_TWIG_PATH, [
            'items' => $this->transformListItems($entities),
            'routePrefix' => 'cms_' . $this->getBaseRouteName(),
        ]);
    }

    #[Route(path: '/new', name: 'new', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $entity = new ($this->getEntityClass());

        return $this->handleForm($request, $entity);
    }

    #[Route(path: '/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function editAction(Request $request, string $id): Response
    {
        $entity = $this->getRepository()->find($id);

        return $this->handleForm($request, $entity);
    }

    protected function handleForm(Request $request, EntityInterface $entity): Response
    {
        $form = $this->createForm($this->getFormTypeClass(), $entity);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render(static::FORM_TWIG_PATH, [
                'form' => $form,
                'entity' => $entity,
                'listPath' => $this->generateUrl('cms_' . $this->getBaseRouteName() . 'index'),
            ]);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $this->redirectToRoute('cms_' . $this->getBaseRouteName() . 'edit', ['id' => $entity->getId()]);
    }

    protected function transformListItems(array $entities): array
    {
        return array_map(fn (EntityInterface $entity) => [
            'id' => $entity->getIdAsRfc4122(),
            'title' => $entity->getIdAsRfc4122(),
        ], $entities);
    }

}