<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SendEmailMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class MailController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/mail/send', name: 'mail_send')]
    public function send(): Response
    {
        $this->messageBus->dispatch(
            new SendEmailMessage('Test-Mail', 'test@guidehub.tld', 'Hello world!'),
        );

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
