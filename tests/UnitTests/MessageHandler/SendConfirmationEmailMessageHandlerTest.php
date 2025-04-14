<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\MessageHandler;

use App\Entity\User;
use App\Message\SendConfirmationEmailMessage;
use App\MessageHandler\SendConfirmationEmailMessageHandler;
use App\Repository\UserRepository;
use App\Service\MailService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

class SendConfirmationEmailMessageHandlerTest extends TestCase
{
    public function testInvokeCallsMailServiceWithCorrectParameters(): void
    {
        $sendEmailMessage = new SendConfirmationEmailMessage(123, 'de_DE');

        $mailServiceMock = $this->createMock(MailService::class);
        $mailServiceMock
            ->expects($this->once())
            ->method('sentEmail');

        $translatorMock     = $this->createMock(TranslatorInterface::class);
        $frontendUrl        = 'http://frontend.tld';
        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock
            ->method('find')
            ->willReturn($this->createMock(User::class));

        $handler = new SendConfirmationEmailMessageHandler(
            $userRepositoryMock,
            $mailServiceMock,
            $translatorMock,
            $frontendUrl,
        );

        $handler($sendEmailMessage);
    }
}
