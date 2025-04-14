<?php

declare(strict_types=1);

namespace App\Message;

final class SendConfirmationEmailMessage
{
    public function __construct(
        private readonly int $userId,
        private readonly string $locale,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
