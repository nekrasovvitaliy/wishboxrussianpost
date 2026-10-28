<?php

declare(strict_types=1);

namespace Tests\Unit\Response\Order;

use PHPUnit\Framework\TestCase;
use WishboxRussianPost\Exception\UnexpectedResponseException;
use WishboxRussianPost\Response\Order\OrderResponseDto;

final class OrderResponseDtoTest extends TestCase
{
    public function test_it_maps_an_order_returned_by_id(): void
    {
        $data = [
            'id' => 123456,
            'barcode' => '10100012345678',
            'order-num' => 'ORDER-42',
            'mail-type' => 'POSTAL_PARCEL',
            'mail-category' => 'ORDINARY',
            'mass' => 1_250,
            'recipient-name' => 'Иванов Иван Иванович',
            'index-to' => 101000,
            'postoffice-code' => '101000',
            'address-changed' => false,
            'delivery-time' => [
                'min-days' => 2,
                'max-days' => 4,
            ],
            'dimension' => [
                'height' => 10,
                'length' => 20,
                'width' => 30,
            ],
            'postmarks' => ['WITHOUT_MARK'],
            'total-rate-wo-vat' => 500,
            'total-vat' => 100,
            'transport-type' => 'SURFACE',
            'version' => 1,
            'delivery-data' => [
                'delivery-point-index' => '101000',
            ],
            'seller-id' => 'SELLER-1',
            'payment-details' => [
                'bank-bik' => '044525225',
            ],
        ];

        $response = OrderResponseDto::fromArray($data);

        self::assertSame(123456, $response->id);
        self::assertSame('10100012345678', $response->barcode);
        self::assertSame('ORDER-42', $response->orderNum);
        self::assertFalse($response->addressChanged);
        self::assertSame(2, $response->deliveryTime?->minDays);
        self::assertSame(4, $response->deliveryTime?->maxDays);
        self::assertSame(20, $response->dimension?->length);
        self::assertSame(['WITHOUT_MARK'], $response->postmarks);
        self::assertSame(500, $response->totalRateWithoutVat);
        self::assertSame(['delivery-point-index' => '101000'], $response->deliveryData);
        self::assertSame('SELLER-1', $response->sellerId);
        self::assertSame(['bank-bik' => '044525225'], $response->paymentDetails);
        self::assertSame($data, $response->rawData);
    }

    public function test_it_rejects_a_response_without_an_integer_id(): void
    {
        $this->expectException(UnexpectedResponseException::class);

        OrderResponseDto::fromArray(['id' => '123456']);
    }
}
