<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'index', methods: ['GET'])]
class IndexController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        return $this->render('index.html.twig', [
            'title' => 'Home',
            'name' => 'Oli'
        ]);
    }
}