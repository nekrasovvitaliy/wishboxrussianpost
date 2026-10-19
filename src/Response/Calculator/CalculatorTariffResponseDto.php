<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Calculator;

use WishboxRussianPost\Exception\UnexpectedResponseException;

final readonly class CalculatorTariffResponseDto
{
    /** @param array<string, mixed> $rawData */
    public function __construct(
        public int           $totalRate,
        public int           $totalVat,
        public ?Tariff       $aviaRate = null,
        public ?Tariff       $completenessCheckingRate = null,
        public ?Tariff       $contentsCheckingRate = null,
        public ?DeliveryTime $deliveryTime = null,
        public ?Tariff       $fragileRate = null,
        public ?Tariff       $groundRate = null,
        public ?Tariff       $insuranceRate = null,
        public ?Tariff       $inventoryRate = null,
        public ?Tariff       $noticeRate = null,
        public ?Tariff       $oversizeRate = null,
        public ?Tariff       $smsNoticeRecipientRate = null,
        public ?Tariff       $vsdRate = null,
        public ?string       $noticePaymentMethod = null,
        public ?string       $paymentMethod = null,
        public array         $rawData = [],
    )
    {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        foreach (['total-rate', 'total-vat'] as $field) {
            if (!is_int($data[$field] ?? null)) {
                throw new UnexpectedResponseException(sprintf(
                    'The tariff response must contain integer %s.',
                    $field,
                ));
            }
        }

        return new self(
            totalRate: $data['total-rate'],
            totalVat: $data['total-vat'],
            aviaRate: self::tariff($data, 'avia-rate'),
            completenessCheckingRate: self::tariff($data, 'completeness-checking-rate'),
            contentsCheckingRate: self::tariff($data, 'contents-checking-rate'),
            deliveryTime: self::deliveryTime($data),
            fragileRate: self::tariff($data, 'fragile-rate'),
            groundRate: self::tariff($data, 'ground-rate'),
            insuranceRate: self::tariff($data, 'insurance-rate'),
            inventoryRate: self::tariff($data, 'inventory-rate'),
            noticeRate: self::tariff($data, 'notice-rate'),
            oversizeRate: self::tariff($data, 'oversize-rate'),
            smsNoticeRecipientRate: self::tariff($data, 'sms-notice-recipient-rate'),
            vsdRate: self::tariff($data, 'vsd-rate'),
            noticePaymentMethod: is_string($data['notice-payment-method'] ?? null)
                ? $data['notice-payment-method']
                : null,
            paymentMethod: is_string($data['payment-method'] ?? null) ? $data['payment-method'] : null,
            rawData: $data,
        );
    }

    /** @param array<string, mixed> $data */
    private static function tariff(array $data, string $key): ?Tariff
    {
        $value = $data[$key] ?? null;

        return is_array($value) ? Tariff::fromArray($value) : null;
    }

    /** @param array<string, mixed> $data */
    private static function deliveryTime(array $data): ?DeliveryTime
    {
        $value = $data['delivery-time'] ?? null;

        return is_array($value) ? DeliveryTime::fromArray($value) : null;
    }
}
