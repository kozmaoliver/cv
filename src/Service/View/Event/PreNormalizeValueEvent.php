<?php

declare(strict_types=1);

namespace App\Service\View\Event;

use App\Service\View\Context\ViewContextInterface;
use Symfony\Contracts\EventDispatcher\Event;

class PreNormalizeValueEvent extends Event
{
    public function __construct(
        private mixed $value,
        private readonly ViewContextInterface $context
    ) {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getContext(): ViewContextInterface
    {
        return $this->context;
    }

}

