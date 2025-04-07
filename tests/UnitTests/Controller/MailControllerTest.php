<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Controller;

use App\Controller\MailController;
use App\Message\SendEmailMessage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class MailControllerTest extends TestCase
{
    private MessageBusInterface&MockObject $messageBusMock;

    protected function setUp(): void
    {
        $this->messageBusMock = $this->createMock(MessageBusInterface::class);
    }

    public function testSend(): void
    {
        $envelope = new Envelope(new SendEmailMessage(
            'test',
            'mail@unit-test.tld',
            'unit-test',
        ));

        $this->messageBusMock
            ->expects(self::once())
            ->method('dispatch')
            ->willReturn($envelope);

        $controller = new MailController($this->messageBusMock);

        $result = $controller->send();

        self::assertSame(Response::HTTP_NO_CONTENT, $result->getStatusCode());
    }
}
