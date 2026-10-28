<?php

declare(strict_types=1);

namespace Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxRussianPost\Api\OrderApi;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Request\Order\OrderUpdateRequestDto;
use WishboxRussianPost\Response\Order\OrderUpdateResponseDto;
use WishboxRussianPost\RussianPostClient;

final class OrderApiTest extends TestCase
{
    public function test_update_sends_put_request_and_maps_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, '{"error-codes":[]}'),
        ]);
        $api = new OrderApi(new RussianPostClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => 'https://example.test',
                'access_token' => 'application-token',
                'user_authorization' => 'user-key',
            ],
        ));

        $response = $api->update(123, $this->createUpdateRequest());

        self::assertInstanceOf(OrderUpdateResponseDto::class, $response);
        self::assertFalse($response->hasErrors());
        self::assertCount(1, $httpClient->requests);

        $sentRequest = $httpClient->requests[0];

        self::assertSame('PUT', $sentRequest->getMethod());
        self::assertSame('https://example.test/1.0/backlog/123', (string) $sentRequest->getUri());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'address-type-to' => 'DEFAULT',
                'mail-category' => 'ORDINARY',
                'mail-direct' => 643,
                'mail-type' => 'POSTAL_PARCEL',
                'mass' => 1_000,
                'order-num' => 'ORDER-123',
                'postoffice-code' => '101000',
                'recipient-name' => 'Иванов Иван Иванович',
            ], JSON_THROW_ON_ERROR),
            (string) $sentRequest->getBody(),
        );
    }

    public function test_update_rejects_invalid_order_id(): void
    {
        $api = new OrderApi(new RussianPostClient(
            new FakeHttpClient(),
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'access_token' => 'application-token',
                'user_authorization' => 'user-key',
            ],
        ));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Russian Post order ID must be greater than zero.');

        $api->update(0, $this->createUpdateRequest());
    }

    private function createUpdateRequest(): OrderUpdateRequestDto
    {
        return new OrderUpdateRequestDto(
            mailType: MailType::PostalParcel,
            mailCategory: MailCategory::Ordinary,
            mass: 1_000,
            orderNum: 'ORDER-123',
            postofficeCode: '101000',
            recipientName: 'Иванов Иван Иванович',
        );
    }
}
