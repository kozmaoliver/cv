<?php

declare(strict_types=1);

namespace App\Service\View\Event;

use App\Service\View\Context\ViewContextInterface;
use Symfony\Contracts\EventDispatcher\Event;

class PreCreateResponseEvent extends Event
{
    public function __construct(
        private readonly mixed $value,
        private readonly array $normalizedValue,
        private readonly ViewContextInterface $context
    ) {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getNormalizedValue(): array
    {
        return $this->normalizedValue;
    }

    public function getContext(): ViewContextInterface
    {
        return $this->context;
    }

}
