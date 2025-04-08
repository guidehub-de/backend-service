<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Message;

use App\Message\SendEmailMessage;
use PHPUnit\Framework\TestCase;

class SendEmailMessageTest extends TestCase
{
    public function testGettersReturnCorrectValues(): void
    {
        $subject   = 'Test Subject';
        $recipient = 'test@example.com';
        $message   = 'This is a test message.';

        $emailMessage = new SendEmailMessage($subject, $recipient, $message);

        self::assertSame($subject, $emailMessage->getSubject());
        self::assertSame($recipient, $emailMessage->getRecipient());
        self::assertSame($message, $emailMessage->getMessage());
    }
}
