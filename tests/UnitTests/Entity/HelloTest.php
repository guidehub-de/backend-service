<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Entity;

use App\Entity\Hello;
use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{
    public function testMessage(): void
    {
        $hello = new Hello();
        $hello->setMessage('Hello!');

        self::assertSame(
            'Hello!',
            $hello->getMessage(),
        );
    }
}
