<?php

declare(strict_types=1);

namespace App\Service\View\Context;

class ViewContext implements ViewContextInterface
{
    private array $members = [];

    public function __construct(
        private int   $status = 200,
        private array $headers = [],
        private array $extra = []
    ) {
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function getMember(string $key, mixed $default = null): mixed
    {
        return ($this->members[$key] ?? $default);
    }

    public function setMember(string $key, mixed $value): void
    {
        $this->members[$key] = $value;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeader(string $key, mixed $value): void
    {
        $this->headers[$key] = $value;
    }

    public function unsetHeader(string $key): void
    {
        unset($this->headers[$key]);
    }

    public function getExtra(string $key, mixed $default = null): mixed
    {
        return $this->extra[$key] ?? $default;
    }

    public function setExtra(string $key, mixed $value): void
    {
        $this->extra[$key] = $value;
    }

    public function toArray(): array
    {
        return [
            'members' => $this->getMembers(),
            'status' => $this->getStatus(),
            'headers' => $this->getHeaders(),
            'extra' => $this->extra
        ];
    }

}
