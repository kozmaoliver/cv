<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/doc', name: 'doc')]
class DocumentationController extends AbstractController
{
    public function __construct(
        #[Autowire("%app.host%")]
        private readonly string $host
    )
    {
    }

    #[Route('/', name: '_index', methods: ['GET'])]
    public function indexAction(): Response
    {
        return $this->render('documentation.html.twig', [
            'apiHost' => $this->host . '/api',
        ]);
    }
}