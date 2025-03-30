<?php

namespace App\Entity\User;

use App\Entity\Shared\Contracts\IdentifiableInterface;
use App\Entity\Shared\Identifiable;
use App\Enum\User\LoginFailureReason;
use App\Repository\User\LoginLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoginLogRepository::class)]
class LoginLog implements IdentifiableInterface
{
    use Identifiable;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $userIdentifier;

    #[ORM\Column(type: Types::STRING, length: 45, nullable: true)]
    private ?string $ipAddress = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $success;

    #[ORM\Column(type: Types::STRING, nullable: true, enumType: LoginFailureReason::class)]
    private ?LoginFailureReason $failureReason = null;

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(string $userIdentifier): void
    {
        $this->userIdentifier = $userIdentifier;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getFailureReason(): ?LoginFailureReason
    {
        return $this->failureReason;
    }

    public function setFailureReason(?LoginFailureReason $failureReason): void
    {
        $this->failureReason = $failureReason;
    }
}