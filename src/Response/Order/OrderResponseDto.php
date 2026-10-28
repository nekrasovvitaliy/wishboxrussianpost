<?php

declare(strict_types=1);

namespace WishboxRussianPost\Response\Order;

use WishboxRussianPost\Exception\UnexpectedResponseException;
use WishboxRussianPost\Request\Calculator\Dimension;
use WishboxRussianPost\Response\Calculator\DeliveryTime;

/**
 * Order returned by GET /1.0/backlog/{id}.
 */
final readonly class OrderResponseDto
{
    /**
     * @param array<string, mixed>|null $customsDeclaration
     * @param array<string, mixed>|null $ecomData
     * @param array<string, mixed>|null $deliveryData
     * @param array<string, mixed>|null $fiscalData
     * @param array<string, mixed>|null $goods
     * @param list<string> $postmarks
     * @param array<string, mixed>|null $paymentDetails
     * @param array<string, mixed> $rawData
     */
    public function __construct(
        public int $id,
        public ?bool $addToMmo = null,
        public ?bool $addressChanged = null,
        public ?string $addressTypeFrom = null,
        public ?string $addressTypeTo = null,
        public ?string $areaFrom = null,
        public ?string $areaTo = null,
        public ?int $aviaRate = null,
        public ?int $aviaRateWithVat = null,
        public ?int $aviaRateWithoutVat = null,
        public ?string $barcode = null,
        public ?int $bkHash = null,
        public ?string $branchName = null,
        public ?string $buildingFrom = null,
        public ?string $buildingTo = null,
        public ?string $comment = null,
        public ?bool $completenessChecking = null,
        public ?int $completenessCheckingRateWithVat = null,
        public ?int $completenessCheckingRateWithoutVat = null,
        public ?int $compulsoryPayment = null,
        public ?int $contentsCheckingRateWithVat = null,
        public ?int $contentsCheckingRateWithoutVat = null,
        public ?string $corpusFrom = null,
        public ?string $corpusTo = null,
        public ?array $customsDeclaration = null,
        public ?string $declarationStatus = null,
        public ?DeliveryTime $deliveryTime = null,
        public ?bool $deliveryWithCod = null,
        public ?Dimension $dimension = null,
        public ?string $dimensionType = null,
        public ?int $easyReturnRateWithVat = null,
        public ?int $easyReturnRateWithoutVat = null,
        public ?array $ecomData = null,
        public ?array $deliveryData = null,
        public ?string $envelopeType = null,
        public ?array $fiscalData = null,
        public ?int $fragileRateWithVat = null,
        public ?int $fragileRateWithoutVat = null,
        public ?int $functionalityCheckingRateWithVat = null,
        public ?int $functionalityCheckingRateWithoutVat = null,
        public ?string $givenName = null,
        public ?array $goods = null,
        public ?int $groundRate = null,
        public ?int $groundRateWithVat = null,
        public ?int $groundRateWithoutVat = null,
        public ?string $groupName = null,
        public ?string $hotelFrom = null,
        public ?string $hotelTo = null,
        public ?string $houseFrom = null,
        public ?string $houseTo = null,
        public ?bool $inMmo = null,
        public ?string $indexFrom = null,
        public ?int $indexTo = null,
        public ?string $innerNum = null,
        public ?int $insuranceRate = null,
        public ?int $insuranceRateWithVat = null,
        public ?int $insuranceRateWithoutVat = null,
        public ?int $insuranceValue = null,
        public ?int $inventoryRateWithVat = null,
        public ?int $inventoryRateWithoutVat = null,
        public ?bool $isDeleted = null,
        public ?string $letterFrom = null,
        public ?string $letterTo = null,
        public ?string $linkedBarcode = null,
        public ?string $locationFrom = null,
        public ?string $locationTo = null,
        public ?string $mailCategory = null,
        public ?int $mailDirect = null,
        public ?string $mailRank = null,
        public ?string $mailType = null,
        public ?int $mass = null,
        public ?int $massRate = null,
        public ?int $massRateWithVat = null,
        public ?int $massRateWithoutVat = null,
        public ?string $middleName = null,
        public ?string $noticePaymentMethod = null,
        public ?int $noticeRateWithVat = null,
        public ?int $noticeRateWithoutVat = null,
        public ?string $numAddressTypeFrom = null,
        public ?string $numAddressTypeTo = null,
        public ?string $officeFrom = null,
        public ?string $officeTo = null,
        public ?string $orderNum = null,
        public ?int $oversizeRateWithVat = null,
        public ?int $oversizeRateWithoutVat = null,
        public ?int $partialRedemptionRateWithVat = null,
        public ?int $partialRedemptionRateWithoutVat = null,
        public ?int $payment = null,
        public ?string $paymentMethod = null,
        public ?string $placeFrom = null,
        public ?string $placeTo = null,
        public array $postmarks = [],
        public ?string $postofficeCode = null,
        public ?bool $prePostalPreparation = null,
        public ?int $prePostalPreparationRateWithVat = null,
        public ?int $prePostalPreparationRateWithoutVat = null,
        public ?int $prepaidAmount = null,
        public ?string $rawAddress = null,
        public ?string $recipientName = null,
        public ?string $regionFrom = null,
        public ?string $regionTo = null,
        public ?string $roomFrom = null,
        public ?string $roomTo = null,
        public ?string $senderComment = null,
        public ?string $senderName = null,
        public ?int $shelfLifeDays = null,
        public ?string $slashFrom = null,
        public ?string $slashTo = null,
        public ?int $smsNoticeRecipient = null,
        public ?int $smsNoticeRecipientRateWithVat = null,
        public ?int $smsNoticeRecipientRateWithoutVat = null,
        public ?string $strIndexTo = null,
        public ?string $streetFrom = null,
        public ?string $streetTo = null,
        public ?string $surname = null,
        public ?int $telAddress = null,
        public ?int $telAddressFrom = null,
        public ?bool $tender = null,
        public ?int $totalRateWithoutVat = null,
        public ?int $totalVat = null,
        public ?string $transportMode = null,
        public ?string $transportType = null,
        public ?int $version = null,
        public ?string $vladenieFrom = null,
        public ?string $vladenieTo = null,
        public ?int $vsdRateWithVat = null,
        public ?int $vsdRateWithoutVat = null,
        public ?int $withFittingRateWithVat = null,
        public ?int $withFittingRateWithoutVat = null,
        public ?string $sellerId = null,
        public ?array $paymentDetails = null,
        public array $rawData = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        if (!is_int($data['id'] ?? null)) {
            throw new UnexpectedResponseException('The order response must contain an integer id.');
        }

        return new self(
            id: $data['id'],
            addToMmo: self::bool($data, 'add-to-mmo'),
            addressChanged: self::bool($data, 'address-changed'),
            addressTypeFrom: self::string($data, 'address-type-from'),
            addressTypeTo: self::string($data, 'address-type-to'),
            areaFrom: self::string($data, 'area-from'),
            areaTo: self::string($data, 'area-to'),
            aviaRate: self::int($data, 'avia-rate'),
            aviaRateWithVat: self::int($data, 'avia-rate-with-vat'),
            aviaRateWithoutVat: self::int($data, 'avia-rate-wo-vat'),
            barcode: self::string($data, 'barcode'),
            bkHash: self::int($data, 'bk-hash'),
            branchName: self::string($data, 'branch-name'),
            buildingFrom: self::string($data, 'building-from'),
            buildingTo: self::string($data, 'building-to'),
            comment: self::string($data, 'comment'),
            completenessChecking: self::bool($data, 'completeness-checking'),
            completenessCheckingRateWithVat: self::int($data, 'completeness-checking-rate-with-vat'),
            completenessCheckingRateWithoutVat: self::int($data, 'completeness-checking-rate-wo-vat'),
            compulsoryPayment: self::int($data, 'compulsory-payment'),
            contentsCheckingRateWithVat: self::int($data, 'contents-checking-rate-with-vat'),
            contentsCheckingRateWithoutVat: self::int($data, 'contents-checking-rate-wo-vat'),
            corpusFrom: self::string($data, 'corpus-from'),
            corpusTo: self::string($data, 'corpus-to'),
            customsDeclaration: self::array($data, 'customs-declaration'),
            declarationStatus: self::string($data, 'declaration-status'),
            deliveryTime: self::deliveryTime($data),
            deliveryWithCod: self::bool($data, 'delivery-with-cod'),
            dimension: self::dimension($data),
            dimensionType: self::string($data, 'dimension-type'),
            easyReturnRateWithVat: self::int($data, 'easy-return-rate-with-vat'),
            easyReturnRateWithoutVat: self::int($data, 'easy-return-rate-wo-vat'),
            ecomData: self::array($data, 'ecom-data'),
            deliveryData: self::array($data, 'delivery-data'),
            envelopeType: self::string($data, 'envelope-type'),
            fiscalData: self::array($data, 'fiscal-data'),
            fragileRateWithVat: self::int($data, 'fragile-rate-with-vat'),
            fragileRateWithoutVat: self::int($data, 'fragile-rate-wo-vat'),
            functionalityCheckingRateWithVat: self::int($data, 'functionality-checking-rate-with-vat'),
            functionalityCheckingRateWithoutVat: self::int($data, 'functionality-checking-rate-wo-vat'),
            givenName: self::string($data, 'given-name'),
            goods: self::array($data, 'goods'),
            groundRate: self::int($data, 'ground-rate'),
            groundRateWithVat: self::int($data, 'ground-rate-with-vat'),
            groundRateWithoutVat: self::int($data, 'ground-rate-wo-vat'),
            groupName: self::string($data, 'group-name'),
            hotelFrom: self::string($data, 'hotel-from'),
            hotelTo: self::string($data, 'hotel-to'),
            houseFrom: self::string($data, 'house-from'),
            houseTo: self::string($data, 'house-to'),
            inMmo: self::bool($data, 'in-mmo'),
            indexFrom: self::string($data, 'index-from'),
            indexTo: self::int($data, 'index-to'),
            innerNum: self::string($data, 'inner-num'),
            insuranceRate: self::int($data, 'insr-rate'),
            insuranceRateWithVat: self::int($data, 'insr-rate-with-vat'),
            insuranceRateWithoutVat: self::int($data, 'insr-rate-wo-vat'),
            insuranceValue: self::int($data, 'insr-value'),
            inventoryRateWithVat: self::int($data, 'inventory-rate-with-vat'),
            inventoryRateWithoutVat: self::int($data, 'inventory-rate-wo-vat'),
            isDeleted: self::bool($data, 'is-deleted'),
            letterFrom: self::string($data, 'letter-from'),
            letterTo: self::string($data, 'letter-to'),
            linkedBarcode: self::string($data, 'linked-barcode'),
            locationFrom: self::string($data, 'location-from'),
            locationTo: self::string($data, 'location-to'),
            mailCategory: self::string($data, 'mail-category'),
            mailDirect: self::int($data, 'mail-direct'),
            mailRank: self::string($data, 'mail-rank'),
            mailType: self::string($data, 'mail-type'),
            mass: self::int($data, 'mass'),
            massRate: self::int($data, 'mass-rate'),
            massRateWithVat: self::int($data, 'mass-rate-with-vat'),
            massRateWithoutVat: self::int($data, 'mass-rate-wo-vat'),
            middleName: self::string($data, 'middle-name'),
            noticePaymentMethod: self::string($data, 'notice-payment-method'),
            noticeRateWithVat: self::int($data, 'notice-rate-with-vat'),
            noticeRateWithoutVat: self::int($data, 'notice-rate-wo-vat'),
            numAddressTypeFrom: self::string($data, 'num-address-type-from'),
            numAddressTypeTo: self::string($data, 'num-address-type-to'),
            officeFrom: self::string($data, 'office-from'),
            officeTo: self::string($data, 'office-to'),
            orderNum: self::string($data, 'order-num'),
            oversizeRateWithVat: self::int($data, 'oversize-rate-with-vat'),
            oversizeRateWithoutVat: self::int($data, 'oversize-rate-wo-vat'),
            partialRedemptionRateWithVat: self::int($data, 'partial-redemption-rate-with-vat'),
            partialRedemptionRateWithoutVat: self::int($data, 'partial-redemption-rate-wo-vat'),
            payment: self::int($data, 'payment'),
            paymentMethod: self::string($data, 'payment-method'),
            placeFrom: self::string($data, 'place-from'),
            placeTo: self::string($data, 'place-to'),
            postmarks: self::stringList($data, 'postmarks'),
            postofficeCode: self::string($data, 'postoffice-code'),
            prePostalPreparation: self::bool($data, 'pre-postal-preparation'),
            prePostalPreparationRateWithVat: self::int($data, 'pre-postal-preparation-rate-with-vat'),
            prePostalPreparationRateWithoutVat: self::int($data, 'pre-postal-preparation-rate-wo-vat'),
            prepaidAmount: self::int($data, 'prepaid-amount'),
            rawAddress: self::string($data, 'raw-address'),
            recipientName: self::string($data, 'recipient-name'),
            regionFrom: self::string($data, 'region-from'),
            regionTo: self::string($data, 'region-to'),
            roomFrom: self::string($data, 'room-from'),
            roomTo: self::string($data, 'room-to'),
            senderComment: self::string($data, 'sender-comment'),
            senderName: self::string($data, 'sender-name'),
            shelfLifeDays: self::int($data, 'shelf-life-days'),
            slashFrom: self::string($data, 'slash-from'),
            slashTo: self::string($data, 'slash-to'),
            smsNoticeRecipient: self::int($data, 'sms-notice-recipient'),
            smsNoticeRecipientRateWithVat: self::int($data, 'sms-notice-recipient-rate-with-vat'),
            smsNoticeRecipientRateWithoutVat: self::int($data, 'sms-notice-recipient-rate-wo-vat'),
            strIndexTo: self::string($data, 'str-index-to'),
            streetFrom: self::string($data, 'street-from'),
            streetTo: self::string($data, 'street-to'),
            surname: self::string($data, 'surname'),
            telAddress: self::int($data, 'tel-address'),
            telAddressFrom: self::int($data, 'tel-address-from'),
            tender: self::bool($data, 'tender'),
            totalRateWithoutVat: self::int($data, 'total-rate-wo-vat'),
            totalVat: self::int($data, 'total-vat'),
            transportMode: self::string($data, 'transport-mode'),
            transportType: self::string($data, 'transport-type'),
            version: self::int($data, 'version'),
            vladenieFrom: self::string($data, 'vladenie-from'),
            vladenieTo: self::string($data, 'vladenie-to'),
            vsdRateWithVat: self::int($data, 'vsd-rate-with-vat'),
            vsdRateWithoutVat: self::int($data, 'vsd-rate-wo-vat'),
            withFittingRateWithVat: self::int($data, 'with-fitting-rate-with-vat'),
            withFittingRateWithoutVat: self::int($data, 'with-fitting-rate-wo-vat'),
            sellerId: self::string($data, 'seller-id'),
            paymentDetails: self::array($data, 'payment-details'),
            rawData: $data,
        );
    }

    /** @param array<string, mixed> $data */
    private static function string(array $data, string $key): ?string
    {
        return self::typedValue($data, $key, 'string');
    }

    /** @param array<string, mixed> $data */
    private static function int(array $data, string $key): ?int
    {
        return self::typedValue($data, $key, 'integer');
    }

    /** @param array<string, mixed> $data */
    private static function bool(array $data, string $key): ?bool
    {
        return self::typedValue($data, $key, 'boolean');
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>|null
     */
    private static function array(array $data, string $key): ?array
    {
        $value = self::typedValue($data, $key, 'array');

        if ($value !== null && array_is_list($value)) {
            throw new UnexpectedResponseException(sprintf(
                'The order response field %s must be an object.',
                $key,
            ));
        }

        return $value;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return list<string>
     */
    private static function stringList(array $data, string $key): array
    {
        if (!array_key_exists($key, $data)) {
            return [];
        }

        $value = $data[$key];

        if (!is_array($value) || !array_is_list($value)) {
            throw new UnexpectedResponseException(sprintf(
                'The order response field %s must be a list.',
                $key,
            ));
        }

        foreach ($value as $item) {
            if (!is_string($item)) {
                throw new UnexpectedResponseException(sprintf(
                    'Every item in the order response field %s must be a string.',
                    $key,
                ));
            }
        }

        return $value;
    }

    /** @param array<string, mixed> $data */
    private static function deliveryTime(array $data): ?DeliveryTime
    {
        $value = self::array($data, 'delivery-time');

        return $value === null ? null : DeliveryTime::fromArray($value);
    }

    /** @param array<string, mixed> $data */
    private static function dimension(array $data): ?Dimension
    {
        $value = self::array($data, 'dimension');

        if ($value === null) {
            return null;
        }

        foreach (['height', 'length', 'width'] as $field) {
            if (!is_int($value[$field] ?? null)) {
                throw new UnexpectedResponseException(sprintf(
                    'The order response dimension must contain integer %s.',
                    $field,
                ));
            }
        }

        return new Dimension(
            height: $value['height'],
            length: $value['length'],
            width: $value['width'],
        );
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return mixed
     */
    private static function typedValue(array $data, string $key, string $type): mixed
    {
        if (!array_key_exists($key, $data)) {
            return null;
        }

        $value = $data[$key];

        if (gettype($value) !== $type) {
            throw new UnexpectedResponseException(sprintf(
                'The order response field %s must be of type %s.',
                $key,
                $type,
            ));
        }

        return $value;
    }
}
