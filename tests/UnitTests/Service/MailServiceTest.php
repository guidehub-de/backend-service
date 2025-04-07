<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Service;

use App\Service\MailService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;

class MailServiceTest extends TestCase
{
    private MailerInterface&MockObject $mailerMock;

    protected function setUp(): void
    {
        $this->mailerMock = $this->createMock(MailerInterface::class);
    }

    public function testSendEmail(): void
    {
        $service = new MailService($this->mailerMock);

        $this->mailerMock
            ->expects(self::once())
            ->method('send');

        $service->sentEmail(
            'test',
            'mail@unit-test.tld',
            'mail@unit-test.tld',
            'unit-test',
        );
    }
}
