<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxRussianPost\Exception\ConfigurationException;
use WishboxRussianPost\Exception\HttpException;
use WishboxRussianPost\RussianPostClient;

final class RussianPostClientTest extends TestCase
{
    public function test_it_rejects_missing_credentials(): void
    {
        $this->expectException(ConfigurationException::class);

        new RussianPostClient(
            new FakeHttpClient(),
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [],
        );
    }

    public function test_it_throws_typed_exception_for_http_error(): void
    {
        $client = new RussianPostClient(
            new FakeHttpClient([
                new FakeResponse(400, '{"message":"Invalid request"}'),
            ]),
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'access_token' => 'AccessToken application-token',
                'user_authorization' => 'Basic user-key',
            ],
        );

        try {
            $client->request('GET', '/failure');
            self::fail('Expected HttpException was not thrown.');
        } catch (HttpException $exception) {
            self::assertSame(400, $exception->getStatusCode());
            self::assertSame('Invalid request', $exception->getMessage());
            self::assertSame(['message' => 'Invalid request'], $exception->getResponseData());
        }
    }
}
