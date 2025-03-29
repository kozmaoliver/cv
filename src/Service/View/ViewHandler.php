<?php

declare(strict_types=1);

namespace App\Service\View;

use App\Service\View\Context\ViewContext;
use App\Service\View\Context\ViewContextInterface;
use App\Service\View\Event\PreCreateResponseEvent;
use App\Service\View\Event\PreNormalizeValueEvent;
use App\Service\View\Event\ResponseCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ViewHandler implements ViewHandlerInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private SerializerInterface      $serializer
    ) {
    }

    public function handle(
        mixed                $data,
        ViewContextInterface $context = new ViewContext(),
    ): Response
    {

        $preNormalizeValueEvent = new PreNormalizeValueEvent($data, $context);
        $this->eventDispatcher->dispatch($preNormalizeValueEvent);

        $data = $preNormalizeValueEvent->getValue();

        $normalizedValue = $this->serializer->normalize($data, context: $context->toArray());

        if (!is_array($normalizedValue)) {
            $normalizedValue = [
                'value' => $normalizedValue
            ];
        }

        $content = $this->serializer->serialize($normalizedValue, 'json', $context->toArray());

        $event = new PreCreateResponseEvent($data, $normalizedValue, $context);
        $this->eventDispatcher->dispatch($event);

        $response = new JsonResponse(
            $content,
            $context->getStatus(),
            $context->getHeaders(),
            true
        );

        $responseCreatedEvent = new ResponseCreatedEvent($response, $context);
        $this->eventDispatcher->dispatch($responseCreatedEvent);

        return $responseCreatedEvent->getResponse();
    }
}