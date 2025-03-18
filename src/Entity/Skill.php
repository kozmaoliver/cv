<?php

namespace App\Entity;

use App\Entity\Shared\Contracts\EntityInterface;
use App\Entity\Shared\Identifiable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Skill implements EntityInterface
{
    use Identifiable;

    #[ORM\Column]
    private ?string $name;

    #[ORM\Column]
    private ?int $yearsOfExperience;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getYearsOfExperience(): ?int
    {
        return $this->yearsOfExperience;
    }

    public function setYearsOfExperience(?int $yearsOfExperience): void
    {
        $this->yearsOfExperience = $yearsOfExperience;
    }
}