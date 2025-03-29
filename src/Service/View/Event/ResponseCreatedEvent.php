<?php

declare(strict_types=1);

namespace App\Service\View\Event;

use App\Service\View\Context\ViewContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\Event;

class ResponseCreatedEvent extends Event
{
    public function __construct(
        private Response $response,
        private readonly ViewContextInterface $context
    ) {
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    public function getContext(): ViewContextInterface
    {
        return $this->context;
    }

}
