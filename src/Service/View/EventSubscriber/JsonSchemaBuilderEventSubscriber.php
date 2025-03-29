<?php

declare(strict_types=1);

namespace App\Service\View\EventSubscriber;

use App\Service\View\Event\PreCreateResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Throwable;

class JsonSchemaBuilderEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            PreCreateResponseEvent::class => 'handle'
        ];
    }

    public function handle(PreCreateResponseEvent $event): void
    {
        $value = $event->getValue();

        if (!$value instanceof Throwable) {
            return;
        }

        $context = $event->getContext();

        $data = $context->getMember('data');

        $context->setMember('data', []);
        $context->setMember('errors', is_array($data) ? $data : [$data]);
    }

}
