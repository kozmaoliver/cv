<?php

namespace App\Entity\Shared\Contracts;

use Symfony\Component\Uid\Uuid;

interface IdentifiableInterface
{
    public function getId(): ?Uuid;

    public function getIdAsRfc4122(): string;
}