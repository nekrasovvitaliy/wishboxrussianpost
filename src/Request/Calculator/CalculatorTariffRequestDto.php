<?php

declare(strict_types=1);

namespace WishboxRussianPost\Request\Calculator;

use InvalidArgumentException;
use WishboxRussianPost\Enum\DimensionType;
use WishboxRussianPost\Enum\EntriesType;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Enum\PaymentMethod;
use WishboxRussianPost\Enum\TransportType;
use WishboxRussianPost\Request\RequestData;

final readonly class CalculatorTariffRequestDto extends RequestData
{
    public function __construct(
        public MailType $mailType,
        public MailCategory $mailCategory,
        public int $mass,
        public bool $inventory,
        public bool $withOrderOfNotice,
        public bool $withSimpleNotice,
        public ?string $indexTo = null,
        public ?string $indexFrom = null,
        public ?int $declaredValue = null,
        public ?Dimension $dimension = null,
        public ?DimensionType $dimensionType = null,
        public ?EntriesType $entriesType = null,
        public ?string $deliveryPointIndex = null,
        public ?PaymentMethod $paymentMethod = null,
        public ?PaymentMethod $noticePaymentMethod = null,
        public ?TransportType $transportType = null,
        public ?int $mailDirect = null,
        public ?int $smsNoticeRecipient = null,
        public ?bool $completenessChecking = null,
        public ?bool $contentsChecking = null,
        public ?bool $courier = null,
        public ?bool $fragile = null,
        public ?bool $vsd = null,
        public ?bool $withElectronicNotice = null,
    ) {
        if ($mass < 0) {
            throw new InvalidArgumentException('mass must not be negative.');
        }

        foreach (
            [
                'declaredValue' => $declaredValue,
                'mailDirect' => $mailDirect,
                'smsNoticeRecipient' => $smsNoticeRecipient,
            ] as $name => $value
        ) {
            if ($value !== null && $value < 0) {
                throw new InvalidArgumentException(sprintf('%s must not be negative.', $name));
            }
        }
    }

    public function toArray(): array
    {
        return $this->withoutNulls([
            'completeness-checking' => $this->completenessChecking,
            'contents-checking' => $this->contentsChecking,
            'courier' => $this->courier,
            'declared-value' => $this->declaredValue,
            'delivery-point-index' => $this->deliveryPointIndex,
            'dimension' => $this->dimension?->toArray(),
            'dimension-type' => $this->dimensionType?->value,
            'entries-type' => $this->entriesType?->value,
            'fragile' => $this->fragile,
            'index-from' => $this->indexFrom,
            'index-to' => $this->indexTo,
            'inventory' => $this->inventory,
            'mail-category' => $this->mailCategory->value,
            'mail-direct' => $this->mailDirect,
            'mail-type' => $this->mailType->value,
            'mass' => $this->mass,
            'notice-payment-method' => $this->noticePaymentMethod?->value,
            'payment-method' => $this->paymentMethod?->value,
            'sms-notice-recipient' => $this->smsNoticeRecipient,
            'transport-type' => $this->transportType?->value,
            'vsd' => $this->vsd,
            'with-electronic-notice' => $this->withElectronicNotice,
            'with-order-of-notice' => $this->withOrderOfNotice,
            'with-simple-notice' => $this->withSimpleNotice,
        ]);
    }
}
