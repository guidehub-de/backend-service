<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Message;

use App\Message\SendConfirmationEmailMessage;
use PHPUnit\Framework\TestCase;

class SendConfirmationEmailMessageTest extends TestCase
{
    public function testGettersReturnCorrectValues(): void
    {
        $emailMessage = new SendConfirmationEmailMessage(123, 'de_DE');

        self::assertSame(123, $emailMessage->getUserId());
        self::assertSame('de_DE', $emailMessage->getLocale());
    }
}
