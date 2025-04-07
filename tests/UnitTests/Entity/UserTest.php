<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAddRole(): void
    {
        $user = new User();

        self::assertEquals(['ROLE_USER'], $user->getRoles());

        $user->addRole('TEST_ROLE');

        self::assertEquals(['TEST_ROLE', 'ROLE_USER'], $user->getRoles());
    }
}
