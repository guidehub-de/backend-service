<?php

declare(strict_types=1);

namespace App\Tests\ApiTests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Message\SendConfirmationEmailMessage;
use Spatie\Snapshots\MatchesSnapshots;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class UserRegistrationTest extends ApiTestCase
{
    use InteractsWithMessenger;
    use MatchesSnapshots;

    public function testRegisterSucceeds(): void
    {
        $client = self::createClient();

        $email = \uniqid() . '@test.tld';

        $response = $client->request('POST', '/users', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'X-Locale'     => 'de_DE',
            ],
            'json'    => [
                'email'    => $email,
                'password' => 'test1234!',
            ],
        ]);

        self::assertResponseIsSuccessful();

        $responseData = $response->toArray();
        self::assertArrayHasKey('confirmationHash', $responseData);
        self::assertArrayHasKey('email', $responseData);
        self::assertEquals(
            $email,
            $responseData['email'],
        );

        $this->transport()->queue()->assertCount(1);
        $this->transport()->queue()->assertContains(SendConfirmationEmailMessage::class);
    }

    public function testRegisterEmailUsed(): void
    {
        $client = self::createClient();

        $email = 'test@test.tld';

        $client->request('POST', '/users', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
                'X-Locale'     => 'de_DE',
            ],
            'json'    => [
                'email'    => $email,
                'password' => 'test1234!',
            ],
        ]);

        self::assertResponseStatusCodeSame(Response::HTTP_CONFLICT);

        $this->transport()->queue()->assertCount(0);
    }
}
