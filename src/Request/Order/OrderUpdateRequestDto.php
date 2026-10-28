<?php

declare(strict_types=1);

namespace WishboxRussianPost\Request\Order;

use InvalidArgumentException;
use WishboxRussianPost\Enum\DimensionType;
use WishboxRussianPost\Enum\MailCategory;
use WishboxRussianPost\Enum\MailType;
use WishboxRussianPost\Enum\PaymentMethod;
use WishboxRussianPost\Enum\TransportType;
use WishboxRussianPost\Request\Calculator\Dimension;
use WishboxRussianPost\Request\RequestData;

/**
 * Request body for PUT /1.0/backlog/{id}.
 *
 * The order ID is a path parameter and therefore is not part of this DTO.
 */
final readonly class OrderUpdateRequestDto extends RequestData
{
    /**
     * @param array<string, mixed>|null $addressFrom
     * @param array<string, mixed>|null $customsDeclaration
     * @param array<string, mixed>|null $ecomData
     * @param array<string, mixed>|null $deliveryData
     * @param array<string, mixed>|null $fiscalData
     * @param array<string, mixed>|null $goods
     * @param array<string, mixed>|null $paymentDetails
     */
    public function __construct(
        public MailType $mailType,
        public MailCategory $mailCategory,
        public int $mass,
        public string $orderNum,
        public string $postofficeCode,
        public string $recipientName,
        public string $addressTypeTo = 'DEFAULT',
        public int $mailDirect = 643,
        public ?int $bkHash = null,
        public ?string $givenName = null,
        public ?string $middleName = null,
        public ?string $surname = null,
        public ?int $indexTo = null,
        public ?string $strIndexTo = null,
        public ?string $regionTo = null,
        public ?string $areaTo = null,
        public ?string $placeTo = null,
        public ?string $locationTo = null,
        public ?string $streetTo = null,
        public ?string $houseTo = null,
        public ?string $buildingTo = null,
        public ?string $corpusTo = null,
        public ?string $letterTo = null,
        public ?string $slashTo = null,
        public ?string $vladenieTo = null,
        public ?string $roomTo = null,
        public ?string $officeTo = null,
        public ?string $hotelTo = null,
        public ?string $numAddressTypeTo = null,
        public ?string $rawAddress = null,
        public ?int $telAddress = null,
        public ?string $senderName = null,
        public ?int $telAddressFrom = null,
        public ?array $addressFrom = null,
        public ?string $branchName = null,
        public ?string $comment = null,
        public ?string $senderComment = null,
        public ?string $groupName = null,
        public ?string $innerNum = null,
        public ?string $sellerId = null,
        public ?int $insuredValue = null,
        public ?int $payment = null,
        public ?int $compulsoryPayment = null,
        public ?int $prepaidAmount = null,
        public ?PaymentMethod $paymentMethod = null,
        public ?PaymentMethod $noticePaymentMethod = null,
        public ?Dimension $dimension = null,
        public ?DimensionType $dimensionType = null,
        public ?TransportType $transportType = null,
        public ?string $transportMode = null,
        public ?string $envelopeType = null,
        public ?int $smsNoticeRecipient = null,
        public ?int $shelfLifeDays = null,
        public ?array $customsDeclaration = null,
        public ?array $ecomData = null,
        public ?array $deliveryData = null,
        public ?array $fiscalData = null,
        public ?array $goods = null,
        public ?array $paymentDetails = null,
        public ?bool $addToMmo = null,
        public ?bool $clientReturn = null,
        public ?bool $completenessChecking = null,
        public ?bool $courier = null,
        public ?bool $deliveryWithCod = null,
        public ?bool $easyReturn = null,
        public ?bool $fragile = null,
        public ?bool $inventory = null,
        public ?bool $manualAddressInput = null,
        public ?bool $noReturn = null,
        public ?bool $prePostalPreparation = null,
        public ?bool $tender = null,
        public ?bool $unloading = null,
        public ?bool $vsd = null,
        public ?bool $withDocuments = null,
        public ?bool $withElectronicNotification = null,
        public ?bool $withGoods = null,
        public ?bool $withOrderOfNotice = null,
        public ?bool $withSimpleNotice = null,
        public ?bool $woMailRank = null,
    ) {
        foreach (
            [
                'mass' => $mass,
                'mailDirect' => $mailDirect,
                'bkHash' => $bkHash,
                'indexTo' => $indexTo,
                'telAddress' => $telAddress,
                'telAddressFrom' => $telAddressFrom,
                'insuredValue' => $insuredValue,
                'payment' => $payment,
                'compulsoryPayment' => $compulsoryPayment,
                'prepaidAmount' => $prepaidAmount,
                'smsNoticeRecipient' => $smsNoticeRecipient,
            ] as $name => $value
        ) {
            if ($value !== null && $value < 0) {
                throw new InvalidArgumentException(sprintf('%s must not be negative.', $name));
            }
        }

        if ($shelfLifeDays !== null && ($shelfLifeDays < 15 || $shelfLifeDays > 60)) {
            throw new InvalidArgumentException('shelfLifeDays must be between 15 and 60.');
        }
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'add-to-mmo' => $this->addToMmo,
            'address-from' => $this->addressFrom,
            'address-type-to' => $this->addressTypeTo,
            'area-to' => $this->areaTo,
            'bk-hash' => $this->bkHash,
            'branch-name' => $this->branchName,
            'building-to' => $this->buildingTo,
            'client-return' => $this->clientReturn,
            'comment' => $this->comment,
            'completeness-checking' => $this->completenessChecking,
            'compulsory-payment' => $this->compulsoryPayment,
            'corpus-to' => $this->corpusTo,
            'courier' => $this->courier,
            'customs-declaration' => $this->customsDeclaration,
            'delivery-with-cod' => $this->deliveryWithCod,
            'dimension' => $this->dimension?->toArray(),
            'dimension-type' => $this->dimensionType?->value,
            'easy-return' => $this->easyReturn,
            'ecom-data' => $this->ecomData,
            'delivery-data' => $this->deliveryData,
            'envelope-type' => $this->envelopeType,
            'fiscal-data' => $this->fiscalData,
            'fragile' => $this->fragile,
            'given-name' => $this->givenName,
            'goods' => $this->goods,
            'group-name' => $this->groupName,
            'hotel-to' => $this->hotelTo,
            'house-to' => $this->houseTo,
            'index-to' => $this->indexTo,
            'inner-num' => $this->innerNum,
            'insr-value' => $this->insuredValue,
            'inventory' => $this->inventory,
            'letter-to' => $this->letterTo,
            'location-to' => $this->locationTo,
            'manual-address-input' => $this->manualAddressInput,
            'mail-category' => $this->mailCategory->value,
            'mail-direct' => $this->mailDirect,
            'mail-type' => $this->mailType->value,
            'mass' => $this->mass,
            'middle-name' => $this->middleName,
            'no-return' => $this->noReturn,
            'notice-payment-method' => $this->noticePaymentMethod?->value,
            'num-address-type-to' => $this->numAddressTypeTo,
            'office-to' => $this->officeTo,
            'order-num' => $this->orderNum,
            'payment' => $this->payment,
            'payment-method' => $this->paymentMethod?->value,
            'place-to' => $this->placeTo,
            'postoffice-code' => $this->postofficeCode,
            'pre-postal-preparation' => $this->prePostalPreparation,
            'prepaid-amount' => $this->prepaidAmount,
            'raw-address' => $this->rawAddress,
            'recipient-name' => $this->recipientName,
            'region-to' => $this->regionTo,
            'room-to' => $this->roomTo,
            'sender-comment' => $this->senderComment,
            'sender-name' => $this->senderName,
            'shelf-life-days' => $this->shelfLifeDays,
            'slash-to' => $this->slashTo,
            'sms-notice-recipient' => $this->smsNoticeRecipient,
            'str-index-to' => $this->strIndexTo,
            'street-to' => $this->streetTo,
            'surname' => $this->surname,
            'tel-address' => $this->telAddress,
            'tel-address-from' => $this->telAddressFrom,
            'tender' => $this->tender,
            'transport-mode' => $this->transportMode,
            'transport-type' => $this->transportType?->value,
            'unloading' => $this->unloading,
            'vladenie-to' => $this->vladenieTo,
            'vsd' => $this->vsd,
            'with-documents' => $this->withDocuments,
            'with-electronic-notification' => $this->withElectronicNotification,
            'with-goods' => $this->withGoods,
            'with-order-of-notice' => $this->withOrderOfNotice,
            'with-simple-notice' => $this->withSimpleNotice,
            'wo-mail-rank' => $this->woMailRank,
            'seller-id' => $this->sellerId,
            'payment-details' => $this->paymentDetails,
        ]);
    }
}
