<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Order;

use PHPUnit\Framework\TestCase;
use WishboxRussianPost\Enum\DimensionType;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Enum\PaymentMethod;
use WishboxRussianPost\Enum\TransportType;
use WishboxRussianPost\Request\Calculator\Dimension;
use WishboxRussianPost\Request\Order\OrderCreateRequestDto;

final class OrderCreateRequestDtoTest extends TestCase
{
    public function test_it_serializes_russian_post_fields_and_omits_nulls(): void
    {
        $request = new OrderCreateRequestDto(
            mailType: MailType::PostalParcel,
            mailCategory: MailCategory::WithDeclaredValueAndCashOnDelivery,
            mass: 1_250,
            orderNum: 'ORDER-42',
            postofficeCode: '101000',
            recipientName: 'Иванов Иван Иванович',
            givenName: 'Иван',
            middleName: 'Иванович',
            surname: 'Иванов',
            indexTo: 101000,
            regionTo: 'Москва',
            placeTo: 'Москва',
            streetTo: 'Тверская',
            houseTo: '1',
            telAddress: 7_999_123_45_67,
            insuredValue: 10_000,
            payment: 8_000,
            paymentMethod: PaymentMethod::Cashless,
            dimension: new Dimension(height: 10, length: 20, width: 30),
            dimensionType: DimensionType::M,
            transportType: TransportType::Surface,
            inventory: false,
            withSimpleNotice: true,
        );

        self::assertSame(
            [
                'address-type-to' => 'DEFAULT',
                'dimension' => [
                    'height' => 10,
                    'length' => 20,
                    'width' => 30,
                ],
                'dimension-type' => 'M',
                'fragile' => false,
                'given-name' => 'Иван',
                'house-to' => '1',
                'index-to' => 101000,
                'insr-value' => 10_000,
                'inventory' => false,
                'mail-category' => 'WITH_DECLARED_VALUE_AND_CASH_ON_DELIVERY',
                'mail-direct' => 643,
                'mail-type' => 'POSTAL_PARCEL',
                'mass' => 1_250,
                'middle-name' => 'Иванович',
                'order-num' => 'ORDER-42',
                'payment' => 8_000,
                'payment-method' => 'CASHLESS',
                'place-to' => 'Москва',
                'postoffice-code' => '101000',
                'recipient-name' => 'Иванов Иван Иванович',
                'region-to' => 'Москва',
                'street-to' => 'Тверская',
                'surname' => 'Иванов',
                'tariff-count' => 1,
                'tel-address' => 7_999_123_45_67,
                'transport-type' => 'SURFACE',
                'with-simple-notice' => true,
            ],
            $request->toArray(),
        );
    }
}
