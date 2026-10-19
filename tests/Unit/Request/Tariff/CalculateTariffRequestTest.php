<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Tariff;

use PHPUnit\Framework\TestCase;
use WishboxRussianPost\Enum\DimensionType;
use WishboxRussianPost\Enum\EntriesType;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Enum\PaymentMethod;
use WishboxRussianPost\Enum\TransportType;
use WishboxRussianPost\Request\Calculator\CalculatorTariffRequestDto;
use WishboxRussianPost\Request\Calculator\Dimension;

final class CalculateTariffRequestTest extends TestCase
{
    public function test_it_serializes_documented_fields_and_omits_nulls(): void
    {
        $request = new CalculatorTariffRequestDto(
            mailType: MailType::PostalParcel,
            mailCategory: MailCategory::Ordinary,
            mass: 1_000,
            inventory: false,
            withOrderOfNotice: false,
            withSimpleNotice: false,
            indexTo: '101000',
            declaredValue: 0,
            dimension: new Dimension(height: 10, length: 20, width: 30),
            dimensionType: DimensionType::M,
            entriesType: EntriesType::SaleOfGoods,
            fragile: false,
            paymentMethod: PaymentMethod::Cashless,
            noticePaymentMethod: PaymentMethod::Stamp,
            transportType: TransportType::Surface,
        );

        self::assertSame(
            [
                'declared-value' => 0,
                'dimension' => [
                    'height' => 10,
                    'length' => 20,
                    'width' => 30,
                ],
                'dimension-type' => 'M',
                'entries-type' => 'SALE_OF_GOODS',
                'fragile' => false,
                'index-to' => '101000',
                'inventory' => false,
                'mail-category' => 'ORDINARY',
                'mail-type' => 'POSTAL_PARCEL',
                'mass' => 1_000,
                'notice-payment-method' => 'STAMP',
                'payment-method' => 'CASHLESS',
                'transport-type' => 'SURFACE',
                'with-order-of-notice' => false,
                'with-simple-notice' => false,
            ],
            $request->toArray(),
        );
    }
}
