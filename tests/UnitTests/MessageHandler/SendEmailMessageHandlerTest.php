<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\MessageHandler;

use App\Message\SendEmailMessage;
use App\MessageHandler\SendEmailMessageHandler;
use App\Service\MailService;
use PHPUnit\Framework\TestCase;

class SendEmailMessageHandlerTest extends TestCase
{
    public function testInvokeCallsMailServiceWithCorrectParameters(): void
    {
        $subject   = 'Test Subject';
        $recipient = 'user@example.com';
        $message   = 'This is a test message.';
        $from      = 'test@guidehub.tld';

        $sendEmailMessage = new SendEmailMessage($subject, $recipient, $message);

        $mailServiceMock = $this->createMock(MailService::class);
        $mailServiceMock
            ->expects($this->once())
            ->method('sentEmail')
            ->with(
                self::equalTo($subject),
                self::equalTo($from),
                self::equalTo($recipient),
                self::equalTo($message),
            );

        $handler = new SendEmailMessageHandler($mailServiceMock);

        $handler($sendEmailMessage);
    }
}
