<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ValidateLocaleHeaderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                'validateLocale',
            ],
        ];
    }

    public function validateLocale(RequestEvent $requestEvent): void
    {
        if (false === $requestEvent->isMainRequest()) {
            return;
        }

        $headers = $requestEvent->getRequest()->headers;

        $contentType = $headers->get('content-type');

        if ('application/json' !== $contentType && 'application/ld+json' !== $contentType) {
            return;
        }

        if (false === $headers->has('x-locale')) {
            throw new BadRequestHttpException('The header "X-Locale" must not be empty.');
        }

        /** @var string $locale */
        $locale = $headers->get('X-Locale');

        $requestEvent->getRequest()->setLocale($locale);
    }
}
