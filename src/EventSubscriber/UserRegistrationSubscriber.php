<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\User;
use App\Message\SendConfirmationEmailMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class UserRegistrationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly RequestStack $requestStack,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                'dispatchConfirmationMail', EventPriorities::POST_WRITE,
            ],
        ];
    }

    public function dispatchConfirmationMail(ViewEvent $event): void
    {
        $user   = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$user instanceof User || Request::METHOD_POST !== $method) {
            return;
        }

        if (!$this->requestStack->getCurrentRequest() instanceof Request) {
            return;
        }

        $locale = $this->requestStack->getCurrentRequest()->getLocale();

        $this->messageBus->dispatch(
            new SendConfirmationEmailMessage($user->getId() ?? 0, $locale),
        );
    }
}
