<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\WorkExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/work-experiences', name: 'work_experiences', methods: ['GET'])]
class WorkExperienceListController extends AbstractController
{
    public function __construct(
        private readonly WorkExperienceRepository $workExperienceRepository,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $workExperiences = $this->workExperienceRepository->findAll();

        $workExperiences = array_map(function ($workExperience) {
            return [
                'company' => $workExperience->getCompany(),
                'jobTitle' => $workExperience->getJobTitle(),
                'startDate' => $workExperience->getStartDate(),
                'endDate' => $workExperience->getEndDate(),
                'technologies' => $workExperience->getTechnologies(),
            ];
        }, $workExperiences);

        return $this->json($workExperiences);
    }
}