<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Support\Http\FakeHttpClient;
use Tests\Support\Http\FakeRequestFactory;
use Tests\Support\Http\FakeResponse;
use Tests\Support\Http\FakeStreamFactory;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Request\Calculator\CalculatorTariffRequestDto;
use WishboxRussianPost\Response\Calculator\CalculatorTariffResponseDto;
use WishboxRussianPost\RussianPostClient;

final class CalculatorApiTest extends TestCase
{
    public function test_calculate_sends_authenticated_request_and_maps_response(): void
    {
        $httpClient = new FakeHttpClient([
            new FakeResponse(200, json_encode([
                'delivery-time' => ['min-days' => 2, 'max-days' => 4],
                'ground-rate' => ['rate' => 12_000, 'vat' => 2_000],
                'total-rate' => 14_000,
                'total-vat' => 2_000,
                'payment-method' => 'CASHLESS',
            ], JSON_THROW_ON_ERROR)),
        ]);
        $client = new RussianPostClient(
            $httpClient,
            new FakeRequestFactory(),
            new FakeStreamFactory(),
            [
                'base_url' => 'https://example.test',
                'access_token' => 'application-token',
                'user_authorization' => 'user-key',
            ],
        );

        $response = $client->calculator()->calculateTariff(new CalculatorTariffRequestDto(
            mailType: MailType::PostalParcel,
            mailCategory: MailCategory::Ordinary,
            mass: 1_000,
            inventory: false,
            withOrderOfNotice: false,
            withSimpleNotice: false,
            indexTo: '101000',
        ));

        self::assertInstanceOf(CalculatorTariffResponseDto::class, $response);
        self::assertSame(14_000, $response->totalRate);
        self::assertSame(2_000, $response->totalVat);
        self::assertSame(12_000, $response->groundRate?->rate);
        self::assertSame(2, $response->deliveryTime?->minDays);
        self::assertSame(4, $response->deliveryTime?->maxDays);

        self::assertCount(1, $httpClient->requests);
        $sentRequest = $httpClient->requests[0];
        self::assertSame('POST', $sentRequest->getMethod());
        self::assertSame('https://example.test/1.0/tariff', (string) $sentRequest->getUri());
        self::assertSame('AccessToken application-token', $sentRequest->getHeaderLine('Authorization'));
        self::assertSame('Basic user-key', $sentRequest->getHeaderLine('X-User-Authorization'));
        self::assertSame('application/json;charset=UTF-8', $sentRequest->getHeaderLine('Content-Type'));
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'index-to' => '101000',
                'inventory' => false,
                'mail-category' => 'ORDINARY',
                'mail-type' => 'POSTAL_PARCEL',
                'mass' => 1_000,
                'with-order-of-notice' => false,
                'with-simple-notice' => false,
            ], JSON_THROW_ON_ERROR),
            (string) $sentRequest->getBody(),
        );
    }
}
