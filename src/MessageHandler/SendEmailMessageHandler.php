<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use App\Service\MailService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendEmailMessageHandler
{
    public function __construct(
        private readonly MailService $mailService,
    ) {
    }

    public function __invoke(SendEmailMessage $message): void
    {
        $this->mailService->sentEmail(
            $message->getSubject(),
            'test@guidehub.tld',
            $message->getRecipient(),
            $message->getMessage(),
        );
    }
}
