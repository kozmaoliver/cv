<?php

namespace App\Entity;

use App\Entity\Shared\Contracts\EntityInterface;
use App\Entity\Shared\Identifiable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class WorkExperience implements EntityInterface
{
    use Identifiable;

    #[ORM\Column]
    private string $company;

    #[ORM\Column]
    private string $jobTitle;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: 'json')]
    private array $technologies = [];

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getTechnologies(): array
    {
        return $this->technologies;
    }

    public function setTechnologies(array $technologies): void
    {
        $this->technologies = $technologies;
    }
}