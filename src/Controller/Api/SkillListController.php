<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\SkillRepository;
use App\Service\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/skills', name: 'skills', methods: ['GET'])]
class SkillListController extends AbstractController
{
    public function __construct(
        private readonly SkillRepository      $skillRepository,
        private readonly ViewHandlerInterface $viewHandler,
    )
    {
    }

    public function __invoke(): Response
    {
        $skills = $this->skillRepository->findAll();

        $skills = array_map(function ($skill) {
            return [
                'name' => $skill->getName(),
                'yearsOfExperience' => $skill->getYearsOfExperience(),
            ];
        }, $skills);

        return $this->viewHandler->handle($skills);
    }
}