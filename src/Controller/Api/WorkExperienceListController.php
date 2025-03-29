<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\WorkExperienceRepository;
use App\Service\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/work-experiences', name: 'work_experiences', methods: ['GET'])]
class WorkExperienceListController extends AbstractController
{
    public function __construct(
        private readonly WorkExperienceRepository $workExperienceRepository,
        private readonly ViewHandlerInterface $viewHandler,
    )
    {
    }

    public function __invoke(): Response
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

        return $this->viewHandler->handle($workExperiences);
    }
}