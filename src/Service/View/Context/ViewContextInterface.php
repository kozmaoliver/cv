<?php

namespace App\Service\View\Context;

interface ViewContextInterface
{
    public function getMembers(): array;

    public function getMember(string $key, mixed $default = null): mixed;

    public function setMember(string $key, mixed $value): void;

    public function getStatus(): int;

    public function setStatus(int $status): void;

    public function getHeaders(): array;

    public function setHeader(string $key, mixed $value): void;

    public function unsetHeader(string $key): void;

    public function getExtra(string $key, mixed $default = null): mixed;

    public function setExtra(string $key, mixed $value): void;

    public function toArray(): array;
}
