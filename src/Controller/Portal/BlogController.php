<?php

declare(strict_types=1);

namespace App\Controller\Portal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog', name: 'blog_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function indexAction(): Response
    {
        return $this->render('blog/index.html.twig', []);
    }
}