<?php

declare(strict_types=1);

namespace App\Tests\ApiTests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class HelloTest extends ApiTestCase
{
    public function testPostHello(): void
    {
        static::createClient()->request('POST', '/hellos', [
            'json' => [
                'message' => 'Hello test',
            ],
        ]);

        self::assertResponseStatusCodeSame(201);
    }
}
