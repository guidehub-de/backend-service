<?php

declare(strict_types=1);

namespace App\Message;

final class SendEmailMessage
{
    public function __construct(
        private readonly string $subject,
        private readonly string $recipient,
        private readonly string $message,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
}
