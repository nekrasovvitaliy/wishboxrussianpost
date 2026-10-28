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
use WishboxRussianPost\Request\Order\OrderUpdateRequestDto;

final class OrderUpdateRequestDtoTest extends TestCase
{
    public function test_it_serializes_russian_post_update_fields_and_omits_nulls(): void
    {
        $request = new OrderUpdateRequestDto(
            mailType: MailType::PostalParcel,
            mailCategory: MailCategory::WithDeclaredValue,
            mass: 1_300,
            orderNum: 'ORDER-42',
            postofficeCode: '101000',
            recipientName: 'Иванов Иван Иванович',
            bkHash: 17,
            givenName: 'Иван',
            surname: 'Иванов',
            indexTo: 101000,
            regionTo: 'Москва',
            placeTo: 'Москва',
            streetTo: 'Тверская',
            houseTo: '1',
            insuredValue: 10_000,
            paymentMethod: PaymentMethod::Cashless,
            dimension: new Dimension(height: 10, length: 20, width: 30),
            dimensionType: DimensionType::M,
            transportType: TransportType::Surface,
            fragile: false,
            inventory: false,
            withElectronicNotification: true,
        );

        self::assertSame(
            [
                'address-type-to' => 'DEFAULT',
                'bk-hash' => 17,
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
                'mail-category' => 'WITH_DECLARED_VALUE',
                'mail-direct' => 643,
                'mail-type' => 'POSTAL_PARCEL',
                'mass' => 1_300,
                'order-num' => 'ORDER-42',
                'payment-method' => 'CASHLESS',
                'place-to' => 'Москва',
                'postoffice-code' => '101000',
                'recipient-name' => 'Иванов Иван Иванович',
                'region-to' => 'Москва',
                'street-to' => 'Тверская',
                'surname' => 'Иванов',
                'transport-type' => 'SURFACE',
                'with-electronic-notification' => true,
            ],
            $request->toArray(),
        );
    }
}
